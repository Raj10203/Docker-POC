FROM php:8.4-fpm-alpine

WORKDIR /var/www/html

# Install build deps, then install and enable the phpredis extension
RUN apk add --no-cache $PHPIZE_DEPS \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del $PHPIZE_DEPS

RUN docker-php-ext-install pdo pdo_mysql
