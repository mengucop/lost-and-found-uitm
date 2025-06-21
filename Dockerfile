FROM php:8.2-fpm

WORKDIR /var/www/html

# Install PHP dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip libonig-dev libxml2-dev libzip-dev nodejs \
    && docker-php-ext-install pdo pdo_mysql zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy project files
COPY . .

# Copy .env
RUN cp .env.example .env

# Install PHP dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# ✅ Install Node and build assets
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install && npm run build

# Laravel setup
RUN php artisan key:generate
RUN php artisan storage:link || true

# Set permissions
RUN chmod -R 775 storage bootstrap/cache && \
    chown -R www-data:www-data storage bootstrap/cache

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
