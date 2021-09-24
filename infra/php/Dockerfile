FROM php:fpm
RUN apt-get update && docker-php-ext-install pdo_mysql
COPY php.ini /usr/local/etc/php/