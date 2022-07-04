FROM php:8.1-fpm
MAINTAINER Erik Dobes

ENV DEBIAN_FRONTEND=noninteractive \
    # disable the warning about running commands as root/super user
    COMPOSER_ALLOW_SUPERUSER=1

RUN apt-get update -y &&\
    apt-get install --no-install-recommends -y wget zip unzip git libicu-dev libpq-dev libpng-dev \
    libxml2-dev gnupg libx11-6 libnss3-dev libmagickwand-dev libzip-dev &&\
    rm -rf /var/lib/apt/lists/*
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer &&\
    curl -sL https://deb.nodesource.com/setup_12.x | bash -
RUN apt-get update && apt-get install -y automake libtool nodejs
RUN docker-php-ext-install pdo_mysql zip xml soap exif \
     && docker-php-ext-configure gd --with-freetype --with-jpeg \
     && docker-php-ext-install -j$(nproc) gd
RUN pecl install xdebug &&\
    docker-php-ext-enable xdebug &&\
    echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini &&\
    echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/xdebug.ini &&\
    echo "xdebug.idekey=PHPSTORM" >> /usr/local/etc/php/conf.d/xdebug.ini &&\
    echo "xdebug.client_host=\"172.17.0.1\"" >> /usr/local/etc/php/conf.d/xdebug.ini

WORKDIR /var/www