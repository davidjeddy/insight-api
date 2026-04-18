FROM php:7.1-fpm

# Install modules
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng12-dev \
        libicu-dev \
            --no-install-recommends

# Added to simplify install for `Instight`
RUN apt-get install -y \
    wget \
    vim

RUN docker-php-ext-install mcrypt zip intl mbstring pdo_mysql exif \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install gd

RUN pecl install -o -f xdebug \
    && rm -rf /tmp/pear

COPY ./php.ini /usr/local/etc/php/
COPY ./www.conf /usr/local/etc/php/

RUN apt-get purge -y g++ \
    && apt-get autoremove -y \
    && rm -r /var/lib/apt/lists/* \
    && rm -rf /tmp/*

RUN usermod -u 1000 www-data

# Added to simplify install for `Instight`
RUN wget https://getcomposer.org/composer.phar -O composer.phar
RUN php composer.phar global require "fxp/composer-asset-plugin"
RUN php composer.phar config -g github-oauth.github.com d576bced0e0cd556cc94cd748ecae95aaf8d53f2

EXPOSE 9000
CMD ["php-fpm"]