FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www/html

# Install system dependencies + Node.js
RUN apt-get update && apt-get install -y \
    git curl zip unzip libonig-dev libxml2-dev libzip-dev \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-install pdo pdo_mysql zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy project files
COPY . .

# Copy .env (needed for artisan commands)
RUN cp .env.example .env

# Install PHP dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Install Node packages and build front-end assets
RUN npm install && npm run build

# Generate Laravel app key
RUN php artisan key:generate

# Set file permissions
RUN chmod -R 775 storage bootstrap/cache && \
    chown -R www-data:www-data storage bootstrap/cache

# Create symbolic link for storage (optional but common)
RUN php artisan storage:link || true

# Expose port
EXPOSE 8000

# Serve the application
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
