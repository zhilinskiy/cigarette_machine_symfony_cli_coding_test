FROM php:8.1.9-cli-alpine

RUN apk --no-cache add pcre-dev ${PHPIZE_DEPS} \
  && pecl install xdebug \
  && docker-php-ext-enable xdebug \
  && apk del pcre-dev ${PHPIZE_DEPS}

COPY .docker/local.ini /usr/local/etc/php/conf.d/zzz_app.ini
