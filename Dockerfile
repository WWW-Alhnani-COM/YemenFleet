# Use official PHP image with FPM
FROM php:8.3-fpm

# Install system dependencies and PHP extensions required by Laravel and PostgreSQL
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpq-dev \
    gnupg \
    && docker-php-ext-install pdo pdo_pgsql

# Install Node.js and npm (LTS version)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs && \
    npm install -g npm

# Install Composer globally
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application files to working directory
COPY . .

# Install PHP dependencies via Composer
RUN composer install --no-dev --optimize-autoloader

# Create storage and cache directories if not present
RUN mkdir -p storage/framework/{cache,sessions,views} bootstrap/cache

# Set correct permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# Install and build frontend assets via Vite
RUN npm install && npm run build

# Expose port used by Laravel
EXPOSE 8000

# Run database migrations and start Laravel's built-in server
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000
