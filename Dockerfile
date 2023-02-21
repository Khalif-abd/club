FROM php:8.1-fpm

ARG user
ARG uid

RUN apt-get update && apt-get install -y \
        libpq-dev \
        libzip-dev \
        libjpeg-dev \
        libpng-dev \
        zip \
        unzip \
        git \
        curl \
        libonig-dev \
        libicu-dev \
        g++ \
    && docker-php-ext-install pdo_pgsql \
    && docker-php-ext-install pgsql \
    && docker-php-ext-install gd \
    && docker-php-ext-enable pgsql


RUN apt-get clean && rm -rf /var/lib/apt/lists/*

ADD ./docker/php-fpm/php.ini /usr/local/etc/php/php.ini

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN chown -R www-data:www-data \
        /var/www/storage \
        /var/www/bootstrap/cache \

WORKDIR /var/www
USER root

EXPOSE 9000
CMD ["php-fpm"]
