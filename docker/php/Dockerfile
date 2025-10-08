FROM php:8.1-apache

# Install system deps and composer
RUN apt-get update && apt-get install -y     git unzip libzip-dev libpng-dev libonig-dev libxml2-dev     && docker-php-ext-install pdo pdo_mysql zip gd mbstring

# Install composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Enable Apache rewrite
RUN a2enmod rewrite

# Install PHPMailer via composer when building (composer.json present)
COPY src/composer.json /var/www/html/composer.json
RUN composer install --no-interaction --no-dev --prefer-dist || true

# Set permissions
RUN chown -R www-data:www-data /var/www/html /var/www/html/uploads || true
