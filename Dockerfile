# استخدم صورة PHP الرسمية مع Apache
FROM php:8.2-apache

# تثبيت المتطلبات الأساسية و PHP Extensions المطلوبة للـ Laravel
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    sqlite3 \
    libsqlite3-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd pdo_sqlite

# تثبيت Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# نسخ ملفات المشروع إلى مجلد Apache
COPY . /var/www/html

# إعداد مجلد العمل
WORKDIR /var/www/html

# تثبيت الحزم عبر Composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# إعداد صلاحيات Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

# إعداد Laravel Key وملف SQLite
RUN cp .env.example .env \
    && touch /var/www/html/database/database.sqlite \
    && php artisan key:generate

# فتح المنفذ 80
EXPOSE 80

# أمر بدء تشغيل Laravel عبر Apache
CMD ["apache2-foreground"]