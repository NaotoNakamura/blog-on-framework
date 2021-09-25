FROM php:fpm
RUN apt-get update && \
  apt-get -y install git && \
  docker-php-ext-install pdo_mysql
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY php.ini /usr/local/etc/php/