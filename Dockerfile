FROM php:8.2-apache

RUN  --mount=type=bind,from=mlocati/php-extension-installer:1.5,source=/usr/bin/install-php-extensions,target=/usr/local/bin/install-php-extensions install-php-extensions \
    iconv \
    imap \
    intl

COPY apache-vhost.conf /etc/apache2/sites-enabled/000-default.conf

RUN mkdir -p /app && chown -R www-data:www-data /app

COPY --chown=www-data . /app

