FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip libonig-dev libxml2-dev libzip-dev nodejs npm \
    && docker-php-ext-install pdo pdo_mysql zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy project files
COPY . .

# Copy .env file (for artisan commands)
RUN cp .env.example .env

# Install PHP dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Install Node modules and build assets
RUN npm install && npm run build

# Generate Laravel app key
RUN php artisan key:generate

# Set permissions
RUN chmod -R 775 storage bootstrap/cache && \
    chown -R www-data:www-data storage bootstrap/cache

# Symlink storage (ignore failure if already linked)
RUN php artisan storage:link || true

EXPOSE 8000

# Serve Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
