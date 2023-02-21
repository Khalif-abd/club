FROM php:8.2-fpm


WORKDIR /app

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

COPY ./composer.* /app/

RUN composer install --no-interaction --no-ansi --no-suggest --prefer-dist  \
        --no-autoloader --no-scripts \
    && composer install --no-dev --no-interaction --no-ansi --no-suggest \
        --prefer-dist --no-autoloader --no-scripts


RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

COPY . /app
COPY --chown=www:www . /app

USER www

#COPY ./entrypoint.sh /usr/local/bin/
#ENTRYPOINT ["entrypoint.sh"]


EXPOSE 9000
CMD ["php-fpm"]
