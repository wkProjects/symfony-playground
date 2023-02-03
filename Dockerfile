FROM php:8.2-apache

RUN  --mount=type=bind,from=mlocati/php-extension-installer:1.5,source=/usr/bin/install-php-extensions,target=/usr/local/bin/install-php-extensions install-php-extensions \
    iconv \
    imap \
    intl \
    zip

COPY apache-vhost.conf /etc/apache2/sites-enabled/000-default.conf

RUN mkdir -p /app && chown www-data: /app
WORKDIR /app
USER www-data
COPY --chown=www-data . /app


RUN --mount=type=bind,from=composer:2,source=/usr/bin/composer,target=/usr/bin/composer \
    composer install

