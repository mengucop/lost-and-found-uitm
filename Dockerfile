FROM php:8.2-fpm

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    git curl zip unzip libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

# Copy .env.example to .env
RUN cp .env.example .env

# Install dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Generate Laravel app key
RUN php artisan key:generate

# Set correct permissions
RUN chmod -R 775 storage bootstrap/cache && \
    chown -R www-data:www-data storage bootstrap/cache

# Optional: Symlink for storage
RUN php artisan storage:link || true

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]

