# the different stages of this Dockerfile are meant to be built into separate images
# https://docs.docker.com/compose/compose-file/#target

ARG PHP_VERSION=7.2
ARG NGINX_VERSION=1.15

### NGINX
FROM nginx:${NGINX_VERSION}-alpine AS symfony_docker_nginx

COPY conf/nginx/conf.d /etc/nginx/conf.d/
#COPY public /srv/app/public/

### PHP
FROM php:${PHP_VERSION}-fpm-alpine AS symfony_docker_php

RUN apk update && apk add --no-cache --update \
		git \
		icu-libs \
		zlib \
		jq \
		nodejs \
		nodejs-npm yarn

ENV APCU_VERSION 5.1.12
RUN set -eux \
	&& apk add --no-cache --virtual .build-deps \
		$PHPIZE_DEPS \
		icu-dev \
		zlib-dev \
	&& docker-php-ext-install pdo_mysql \
	&& docker-php-ext-install -j$(nproc) \
		intl \
		zip \
	&& pecl install \
		apcu-${APCU_VERSION} \
	&& docker-php-ext-enable --ini-name 20-apcu.ini apcu \
	&& docker-php-ext-enable --ini-name 05-opcache.ini opcache \
	&& runDeps="$( \
        scanelf --needed --nobanner --format '%n#p' --recursive /usr/local/lib/php/extensions \
            | tr ',' '\n' \
            | sort -u \
            | awk 'system("[ -e /usr/local/lib/" $1 " ]") == 0 { next } { print "so:" $1 }' \
    )" \
    && apk add --no-cache --virtual .api-phpexts-rundeps $runDeps \
	&& apk del .build-deps

RUN ln -s $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini
#RUN ln -s $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini
COPY conf/app/conf.d/symfony.ini $PHP_INI_DIR/conf.d/symfony.ini
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
#COPY docker/app/docker-entrypoint.sh /usr/local/bin/docker-app-entrypoint
#RUN chmod +x /usr/local/bin/docker-app-entrypoint

RUN mkdir /.composer
RUN chmod -R 777 /.composer

RUN mkdir /.yarn
RUN chmod -R 777 /.yarn
#RUN mkdir /.yarnrc
#RUN chmod -R 777 /.yarnrc

#RUN chown -R ${UID}:${GID} /.yarn

WORKDIR /var/www
#ENTRYPOINT ["docker-app-entrypoint"]
CMD ["php-fpm"]

# https://getcomposer.org/doc/03-cli.md#composer-allow-superuser
ENV COMPOSER_ALLOW_SUPERUSER 1

# Use prestissimo to speed up builds
#RUN composer global require "symfony/flex" --prefer-dist --no-progress --no-suggest --classmap-authoritative  --no-interaction

# Allow to use development versions of Symfony
#ARG STABILITY="stable"
#ENV STABILITY ${STABILITY:-stable}

# Allow to select skeleton version
#ARG SYMFONY_VERSION=""

# Download the Symfony skeleton and leverage Docker cache layers
#RUN composer create-project "symfony/skeleton ${SYMFONY_VERSION}" . --stability=$STABILITY --prefer-dist --no-dev --no-progress --no-scripts --no-plugins --no-interaction

###> recipes ###
###< recipes ###

COPY . .

#RUN mkdir -p var/cache var/logs var/sessions \
#    && composer install --prefer-dist --no-dev --no-scripts --no-progress --no-suggest --classmap-authoritative --no-interaction \
#    && composer clear-cache \
#    && chown -R www-data var
