FROM php:7.4-apache

RUN a2enmod rewrite headers \
    && printf '%s\n' \
        '<Directory /var/www/html/>' \
        '    Options Indexes FollowSymLinks' \
        '    AllowOverride All' \
        '    Require all granted' \
        '</Directory>' \
        > /etc/apache2/conf-available/iqmaximo-allowoverride.conf \
    && a2enconf iqmaximo-allowoverride \
    && apt-get update \
    && apt-get install -y --no-install-recommends libzip-dev zip unzip \
    && docker-php-ext-install mysqli pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

COPY . /var/www/html/
