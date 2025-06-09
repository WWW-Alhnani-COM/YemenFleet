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

# Ensure bootstrap/cache exists and is writable before Composer install
RUN mkdir -p bootstrap/cache \
    && chmod -R 775 bootstrap/cache

# Install PHP dependencies via Composer
RUN composer install --no-dev --optimize-autoloader

# Set permissions for Laravel storage and cache directories
RUN chown -R www-data:www-data storage bootstrap/cache

# Expose port (use the port Render will route to, usually 10000 or 8000)
EXPOSE 8000

# Run database migrations before starting the server and then start Laravel's built-in server
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000
