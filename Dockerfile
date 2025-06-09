# Use official PHP image with FPM
FROM php:8.3-fpm

# Install system dependencies and PHP extensions required by Laravel and PostgreSQL
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpq-dev \
    libzip-dev \
    zip \
    nodejs \
    npm \
    && docker-php-ext-install pdo pdo_pgsql zip

# Install Composer globally
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . 
# Create required Laravel directories and set correct permissions
RUN mkdir -p \
    bootstrap/cache \
    storage/framework/{cache,sessions,views} \
    storage/logs && \
    chown -R www-data:www-data bootstrap/cache storage && \
    chmod -R 775 bootstrap/cache storage

# Create required Laravel directories before Composer
RUN mkdir -p storage/framework/{cache,sessions,views} bootstrap/cache

# Set correct permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Install JS dependencies and build Vite assets
RUN npm install && npm run build

# Expose Laravel's default port (used by Render or similar platforms)
EXPOSE 8000

# Run database migrations and start Laravel server
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000
