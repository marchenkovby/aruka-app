FROM php:8.0-apache

WORKDIR /var/www/html

EXPOSE 80

COPY . .

RUN apt-get update && apt-get install -y git zip unzip && pecl install xdebug

RUN docker-php-ext-install pdo_mysql

RUN docker-php-ext-enable pdo_mysql xdebug

RUN mv ${PHP_INI_DIR}/php.ini-development ${PHP_INI_DIR}/php.ini

COPY docker/apache/apache.conf /etc/apache2/sites-available/000-default.conf

COPY docker/php/timezone.ini /usr/local/etc/php/conf.d/timezone.ini

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN a2enmod rewrite
