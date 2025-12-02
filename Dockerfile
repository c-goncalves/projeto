FROM php:8.2-apache
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libicu-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql opcache intl 

RUN a2enmod rewrite
WORKDIR /var/www/html