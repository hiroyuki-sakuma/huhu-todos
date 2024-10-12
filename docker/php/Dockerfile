FROM php:8.0-apache

COPY ./php.ini /usr/local/etc/php/

RUN apt-get update -y && \
    apt-get upgrade -y && \
    apt-get -y install \
    libicu-dev \
    libzip-dev \
    libonig-dev \
    zip \
    unzip \
    libssl-dev  && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* && \
    docker-php-ext-install intl mbstring opcache pdo_mysql zip

WORKDIR /var/www/html

EXPOSE 80

RUN a2enmod rewrite