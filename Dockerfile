FROM php:8.1-cli-alpine

RUN apk update && \
    apk add --no-cache tzdata openssl-dev pkgconfig autoconf build-base brotli-dev && \
    pecl channel-update pecl.php.net && \
    pecl install swoole && \
    docker-php-ext-enable swoole && \
    docker-php-ext-install pdo_mysql && \
    rm -rf /var/cache/apk/*

WORKDIR /var/www

COPY . /var/www

EXPOSE 6060

CMD ["php", "/var/www/src/Server.php"]