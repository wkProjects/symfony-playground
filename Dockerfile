FROM php:8.2-apache

RUN  --mount=type=bind,from=mlocati/php-extension-installer:2.1.65,source=/usr/bin/install-php-extensions,target=/usr/local/bin/install-php-extensions install-php-extensions \
    iconv \
    imap \
    intl \
    zip

COPY apache-vhost.conf /etc/apache2/sites-enabled/000-default.conf

RUN mkdir -p /app && chown www-data: /app
WORKDIR /app
COPY --chown=www-data . /app

USER www-data
ENV APP_ENV=prod

RUN --mount=type=bind,from=composer:2,source=/usr/bin/composer,target=/usr/bin/composer \
    composer install --no-dev --optimize-autoloader

USER root
