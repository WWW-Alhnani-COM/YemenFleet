# Use official PHP image with FPM
FROM php:8.3-fpm

# Install system dependencies and PHP extensions required by Laravel and PostgreSQL
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Install Composer globally
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application files to working directory
COPY . .

# Create required Laravel directories if not present
RUN mkdir -p storage/app \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache

# Set permissions for Laravel storage and cache directories
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Install PHP dependencies via Composer
RUN composer install --no-dev --optimize-autoloader

# Expose port (Render uses 8000 or 10000)
EXPOSE 8000

# Run database migrations and start Laravel server
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000
