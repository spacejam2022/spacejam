FROM registry-1.docker.io/library/php:7-fpm-alpine3.7

RUN apk update && apk --no-cache add \
    $PHPIZE_DEPS \
    fcgi \
    curl \
    socat \
    sudo

RUN docker-php-ext-install pdo pdo_mysql
RUN pecl install xdebug
RUN apk del $PHPIZE_DEPS

RUN docker-php-ext-enable xdebug
RUN echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.remote_connect_back=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.remote_port=9005" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

COPY sudoers /etc/sudoers

COPY code /code
COPY cmd.php /usr/local/lib/php/
COPY log.conf /usr/local/etc/php-fpm.d/zz-log.conf