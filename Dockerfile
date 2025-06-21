FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www/html

# Install PHP and system dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# ✅ Install Node.js + npm
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# ✅ Verify install
RUN node -v && npm -v

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy app code
COPY . .

# ✅ Copy .env and prepare APP_KEY
RUN cp .env.example .env && \
    sed -i '/^APP_KEY=/d' .env && \
    echo "APP_KEY=" >> .env && \
    echo "APP_DEBUG=true" >> .env


# Install PHP dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# ✅ Build Vite assets
RUN npm install
RUN npm run build

# Laravel setup
RUN php artisan key:generate
RUN php artisan storage:link || true
RUN chmod -R 775 storage bootstrap/cache && chown -R www-data:www-data storage bootstrap/cache
RUN chown -R www-data:www-data .

# Expose port
EXPOSE 8000

# ✅ Serve app from /public using PHP built-in server
CMD php -S 0.0.0.0:8000 -t public router.php
