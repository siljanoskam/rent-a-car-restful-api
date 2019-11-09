# This is a monolithic container for running laravel based applications.
# Includes tools for installing dependencies like composer
FROM php:7.1-apache
LABEL "version"="1.4.0" "application"="laravel"
ADD vhost.conf /var/www/vhost.conf
# Resolve error: TERM environment variable not set.
ENV TERM xterm
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        ssh \
        nano-tiny \
        openssl \
        libxml2-dev \
        zlib1g-dev \
        libpng-dev \
        libicu-dev \
        gnupg2 \
        libzip-dev \
        unzip \
        # for mozjpeg: building from source
        build-essential cmake libtool autoconf automake m4 nasm \
    && docker-php-ext-install zip \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && docker-php-ext-install bcmath \
    && echo "Installing Xdebug - but it will not be activated" \
    && pecl install xdebug-2.6.1 \
    && echo "### INSTALL COMPOSER (1.8.0) ###" \
    && php -r "copy('https://raw.githubusercontent.com/composer/getcomposer.org/d3e09029468023aa4e9dcd165e9b6f43df0a9999/web/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/local/bin/composer \
    && echo "### ACTIVATE APACHE mod_rewrite ###" \
    && a2enmod rewrite \
    && echo "### ADD VHOST CONFIGURATION ###" \
    && mv /var/www/vhost.conf /etc/apache2/sites-enabled/000-default.conf \
    && echo "### CLEANUP ###" \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

