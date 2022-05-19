FROM php:fpm-alpine as php-fpm

WORKDIR /var/www

RUN docker-php-ext-install pdo pdo_mysql

RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
    && apk add shadow \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && apk del -f .build-deps

RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

ADD . /var/www

RUN chown -R www-data:www-data /var/www

RUN usermod -u 1000 www-data

USER www-data
