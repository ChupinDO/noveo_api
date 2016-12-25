FROM php:7.0-fpm
MAINTAINER Daniil Chupin <chupindo@gmail.com>

RUN apt-get update && apt-get install -y \
    libmcrypt-dev \
    libcurl3-dev \
    libxml2-dev \
    libzzip-dev \
    zlib1g-dev \
    libicu-dev \
    libpq-dev \
    g++ \
    git \
    && docker-php-ext-install -j$(nproc) \
    curl \
    mbstring \
    intl \
    pdo_pgsql

# Install composer and global asset plugin
ENV COMPOSER_HOME /root/.composer
ENV PATH /root/.composer/vendor/bin:$PATH

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    /usr/local/bin/composer global require "fxp/composer-asset-plugin"

# App section
ADD . /var/www/html
WORKDIR /var/www/html

RUN /usr/local/bin/composer install

VOLUME ["/var/www/html"]