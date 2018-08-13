FROM php:7.1-fpm-alpine

ENV PHPIZE_DEPS \
    autoconf \
    g++ \
    make \
    file \
    re2c \
    curl

ENV EXT_DEPS \
    freetype-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    openssl-dev \
    icu-dev \
    sqlite-dev

ENV PHP_EXTS \
    mbstring \
    bcmath \
    gd \
    opcache \
    pdo_mysql \
    pdo_sqlite \
    intl \
    zip

ENV PECL_EXTS \
    apcu \
    redis \
    xdebug

RUN apk add --update --no-cache --virtual .build-deps ${PHPIZE_DEPS} \
    && apk add --update --no-cache git bash vim ${EXT_DEPS} \
    # Install PHP Core Extensions
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install ${PHP_EXTS} \
    # Install PECL Extensions
    && pecl channel-update pecl.php.net \
    && pecl install ${PECL_EXTS} \
    && docker-php-ext-enable ${PECL_EXTS} \
    # Install Composer
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    # Clean up
    && apk del .build-deps \
    && rm -rf /var/cache/apk/*

RUN echo http://dl-2.alpinelinux.org/alpine/edge/community/ >> /etc/apk/repositories \
    && apk --no-cache add shadow && usermod -u 1000 www-data
