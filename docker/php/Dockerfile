FROM php:8.2-apache

COPY ./php.ini /usr/local/etc/php/

RUN apt-get update && \
    apt-get install -y \
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

RUN sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf
