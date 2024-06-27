FROM php:7.4-fpm

# Install any additional PHP extensions if needed
RUN docker-php-ext-install pdo pdo_mysql mysqli

COPY ./html /var/www/html

WORKDIR /var/www/html
