FROM php:7.2-fpm-alpine

RUN addgroup -g 1000 laravel && adduser -G laravel -g laravel -s /bin/sh -D laravel

RUN mkdir -p /var/www/html


RUN chown laravel:laravel /var/www/html
# Install selected extensions and other stuff
RUN apk update \
	&& apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
	&& pecl install redis \
	&& apk --no-cache add \
	postgresql-dev \
	&& apk del -f .build-deps

WORKDIR /var/www/html/

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
	
COPY . .

RUN docker-php-ext-install pdo pdo_pgsql

RUN docker-php-ext-enable redis

