# استخدام صورة PHP الرسمية مع FPM
FROM php:8.3-fpm

# تثبيت الحزم اللازمة لـ Laravel وPostgreSQL وVite
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

# نسخ Composer من صورة رسمية
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# تعيين مجلد العمل
WORKDIR /var/www/html

# نسخ ملفات المشروع إلى الحاوية
COPY . .

# إنشاء مجلدات Laravel المطلوبة وحل مشكلة الكاش
RUN mkdir -p \
    bootstrap/cache \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs && \
    chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache

# تثبيت مكتبات PHP بدون بيئة التطوير
RUN composer install --no-dev --optimize-autoloader

# تثبيت مكتبات JavaScript وبناء ملفات Vite
RUN npm install && npm run build

# فتح المنفذ 8000 لتشغيل السيرفر
EXPOSE 8000

# تنفيذ الأوامر: هجرة قواعد البيانات وتشغيل الخادم
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000
