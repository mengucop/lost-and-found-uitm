# Use official PHP image with required extensions
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www/html

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git curl zip unzip libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy project files
COPY . .

# Install Laravel dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Set permissions for Laravel to write to cache/logs
RUN chmod -R 775 storage bootstrap/cache \
 && chown -R www-data:www-data storage bootstrap/cache

# Generate Laravel key
RUN php artisan key:generate

# Laravel migration (optional: comment this if you want manual)
# RUN php artisan migrate --force

# Symlink storage
RUN php artisan storage:link || true

# Expose port 8000
EXPOSE 8000

# Start Laravel dev server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
