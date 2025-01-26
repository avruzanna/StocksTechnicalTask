# Use PHP 8.2 FPM image
FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    zip unzip curl git libpng-dev libonig-dev libxml2-dev libzip-dev default-mysql-client\
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && pecl install redis \
    && docker-php-ext-enable redis

RUN apt-get install cron -y 

RUN docker-php-ext-install pdo pdo_mysql zip gd

WORKDIR /var/www/html

COPY . .

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

#Cron 

COPY crontab /etc/cron.d/laravel-cron

RUN chmod 0644 /etc/cron.d/laravel-cron

RUN crontab /etc/cron.d/laravel-cron
RUN touch /var/log/cron.log



# Migration and Seeders
COPY run.sh /usr/local/bin/run.sh
RUN chmod +x /usr/local/bin/run.sh

ENTRYPOINT ["/usr/local/bin/run.sh"]
