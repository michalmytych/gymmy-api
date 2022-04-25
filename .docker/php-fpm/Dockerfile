FROM php:fpm-alpine as php-fpm

RUN docker-php-ext-install pdo pdo_mysql

RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
    && apk add shadow \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && apk del -f .build-deps

RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

RUN usermod -u 1000 www-data

USER www-data
