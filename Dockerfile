# syntax=docker/dockerfile:1

# ---- Build: vendor/ via composer, no dev dependencies ----
FROM composer:2 AS build

# codeigniter4/framework requires ext-intl at composer's platform-check
# step, which the composer:2 base image doesn't ship with by default.
RUN apk add --no-cache icu-dev && docker-php-ext-install intl

WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-interaction --optimize-autoloader

COPY . .
RUN composer dump-autoload --no-dev --optimize

# ---- Runtime: PHP-FPM + Nginx in one container (supervisord) ----
FROM php:8.3-fpm-alpine

RUN apk add --no-cache nginx supervisor icu-libs \
    && apk add --no-cache --virtual .build-deps $PHPIZE_DEPS icu-dev \
    && docker-php-ext-install mysqli intl opcache \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del .build-deps

WORKDIR /var/www/html

COPY --from=build /app /var/www/html

# Stock CI4 writable/ subtree, kept as a same-pod fallback (e.g. if
# cache/session env vars are ever left unset) -- Redis is the intended
# backend in production, see app/Config/Cache.php / Session.php.
RUN chown -R www-data:www-data /var/www/html/writable

COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/www.conf /usr/local/etc/php-fpm.d/www.conf
COPY docker/supervisord.conf /etc/supervisord.conf

# AWS RDS CA bundle (all regions) -- see app/Config/Database.php's
# 'encrypt' default and charts/tundra/values.yaml's config.database.sslCA.
COPY docker/rds-global-bundle.pem /etc/ssl/rds/global-bundle.pem

EXPOSE 80

CMD ["supervisord", "-c", "/etc/supervisord.conf"]
