FROM php:8.2-fpm

ARG HOST_UID
ARG NODE_VERSION=16

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y apt-utils \
    && apt-get install -y \
        zlib1g-dev \
        libicu-dev \
        libpq-dev \
        libpcre3-dev \
        nano \
        libzip-dev\
        zip \
        unzip \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libmagickwand-dev \
        wget \
        gnupg \
        libxpm-dev \
        libvpx-dev \
        libwebp-dev \
        libjpeg-dev \
        libpng-dev \
        iproute2 \
        git \
        sqlite3 \
        libsqlite3-dev \
        supervisor \
        cron \
        librdkafka-dev --fix-missing \
    && docker-php-ext-configure zip \
    && docker-php-ext-configure gd --enable-gd --with-jpeg \
    && docker-php-ext-install -j$(nproc) iconv intl zip pdo_mysql mysqli exif bcmath gd pcntl

# Install Phpredis
RUN pecl install -o -f redis \
&&  rm -rf /tmp/pear \
&&  docker-php-ext-enable redis

# Install Php settings
COPY php.ini /usr/local/etc/php/conf.d/php.ini
COPY www.conf /usr/local/etc/php-fpm.d/www.conf

# Install rdkafka
RUN pecl install rdkafka
RUN echo "extension=rdkafka.so" >> /usr/local/etc/php/conf.d/php.ini

# Install Imagick
RUN apt-get install -y libmagickwand-dev
RUN pecl install imagick
RUN docker-php-ext-enable imagick

# Install Composer
ADD ./composer.sh ./
RUN chmod +x ./composer.sh && ./composer.sh

#install Xdebug
RUN yes | pecl install xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" \
    > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini
RUN echo "memory_limit=2G" >> /usr/local/etc/php/conf.d/memory.ini

# Install Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_$NODE_VERSION.x | bash - \
    && DEBIAN_FRONTEND=noninteractive apt-get install nodejs --no-install-recommends -yqq

# Install Yarn
RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - \
    && echo "deb https://dl.yarnpkg.com/debian/ stable main" > /etc/apt/sources.list.d/yarn.list \
    && apt-get update \
    && apt-get install -y yarn

#Install System Tools
RUN apt-get update \
    && apt-get -y upgrade \
    && apt-get install -y vim \
    && apt-get install -y htop \
    && apt-get install -y lsof \
    && apt-get install -y inotify-tools \
    && apt-get install iputils-ping

# Clean Up Files
RUN apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN usermod -u $HOST_UID www-data && groupmod -g $HOST_UID www-data && chsh -s /bin/bash www-data

# Copy bash & sh aliases
COPY ./.bashrc /root/.bashrc
RUN cp /root/.bashrc /var/www
COPY ./.shrc /root/.shrc
#RUN cp /root/.shrc /var/www

