FROM node:18-alpine AS node_modules
WORKDIR /app
COPY package*.json ./
RUN npm install

FROM php:8.2-fpm
WORKDIR /var/www/html

# Install PHP extensions
RUN apt-get update && apt-get install -y \
    git curl zip unzip libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy all code
COPY . .

# Copy Node modules
COPY --from=node_modules /app/node_modules ./node_modules

# Set correct .env
RUN cp .env.example .env

# Install PHP dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Build Vite assets
RUN npm run build

# Laravel setup
RUN php artisan key:generate
RUN php artisan storage:link || true
RUN chmod -R 775 storage bootstrap/cache && chown -R www-data:www-data storage bootstrap/cache

# Set correct permissions
RUN chown -R www-data:www-data .

EXPOSE 8000

# ✅ This line serves from public folder, allowing static Vite assets to work
CMD php -S 0.0.0.0:8000 -t public
