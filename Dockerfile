# Use official PHP image with FPM
FROM php:8.3-fpm

# Install system dependencies and PHP extensions required by Laravel and PostgreSQL
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpq-dev \
    nodejs \
    npm \
    && docker-php-ext-install pdo pdo_pgsql

# Install Composer globally
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application files to working directory
COPY . .

# Install PHP dependencies via Composer
RUN composer install

# Install JS dependencies and build assets with Vite
RUN npm install && npm run build

# تأكد من إنشاء مجلدات Laravel الضرورية
RUN mkdir -p storage/app storage/framework storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

# Expose port
EXPOSE 8000

# Run migrations and serve the app
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000
