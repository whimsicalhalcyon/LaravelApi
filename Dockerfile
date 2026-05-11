FROM richarvey/nginx-php-fpm:2.2.0

# Настройки окружения
ENV WEBROOT=/var/www/html/public
ENV PHP_ERRORS_STDERR=1
ENV RUN_SCRIPTS=1
ENV REAL_IP_HEADER=1

# копирование файлов проекта
COPY . /var/www/html

# зависимости
WORKDIR /var/www/html

# композер
RUN composer install --no-dev --optimize-autoloader --no-interaction

# vue
RUN npm ci --omit=dev && npm run build

# Laravel
RUN php artisan optimize:clear
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

# права на папки
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80
