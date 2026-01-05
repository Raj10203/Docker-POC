FROM php:8.4-apache

WORKDIR /var/www/html/

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

# Configure Apache to serve from public folder
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    curl \
    git \
    && docker-php-ext-install -j$(nproc) zip pdo_mysql

COPY composer.json composer.lock ./

# Install composer and dependencies in one layer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer install --no-scripts --no-autoloader --no-dev --prefer-dist --optimize-autoloader

# Copy the rest of the application
COPY . .

# Ensure storage and cache directories exist and are writable by the Apache user
RUN mkdir -p /var/www/html/storage /var/www/html/storage/framework /var/www/html/storage/framework/sessions /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
