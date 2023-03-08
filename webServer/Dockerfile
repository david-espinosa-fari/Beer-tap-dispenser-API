FROM php:7.4.33-apache
ARG PATH_APACHE2_SECURITY_CONFIG
ARG PATH_APACHE2_CONFIG
ARG PATH_PHP_INI_CONFIG
ARG PATH_VHOST_CONFIG_DEFAULT
ARG PATH_DATABASE_YML_DIST_CONFIG
ARG PATH_MOCKUP_YML_DIST_CONFIG
RUN apt-get update && \
    apt-get install ca-certificates && \
    update-ca-certificates -f -v
RUN apt-get -y update --fix-missing
RUN apt-get upgrade -y
RUN apt-get -y install wget curl libcurl4 gnupg2
RUN apt-get -y install --fix-missing apt-utils build-essential zip
RUN apt-get -y install libpng-dev libjpeg-dev libjpeg62-turbo-dev libfreetype6-dev libvpx-dev libwebp-dev libxpm-dev bzip2
RUN apt-get -y install mcrypt
RUN apt-get -y install --fix-missing libcurl4-openssl-dev pkg-config libssl-dev
RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-install sockets
RUN docker-php-ext-enable pdo_mysql
RUN docker-php-ext-install gettext bcmath exif
RUN docker-php-ext-enable sodium gettext
RUN docker-php-ext-enable bcmath exif
RUN pecl config-set php_ini /usr/local/etc/php/php.ini

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Enable apache modules
RUN a2enmod rewrite headers ssl

RUN apt-get -y install libxml2-dev
RUN docker-php-ext-install soap

RUN docker-php-ext-configure intl \
    && docker-php-ext-install intl

RUN docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
    && docker-php-ext-install gd

RUN pecl install apcu
RUN docker-php-ext-enable apcu

RUN apt-get install -y git \
    libcurl4-openssl-dev make \
    libpcre3-dev \
    gcc autoconf libc-dev pkg-config \
    libmcrypt-dev \
    libtool-bin  default-libmysqlclient-dev \
    g++ zlib1g-dev

RUN docker-php-ext-install shmop sysvmsg sysvsem sysvshm
RUN docker-php-ext-enable shmop sysvmsg sysvsem sysvshm

RUN apt-get install -y vim \
    iputils-ping

RUN apt-get update && \
    apt-get install ca-certificates && \
    update-ca-certificates -f -v

RUN apt-get install -y libzip-dev libzip4
RUN docker-php-ext-configure zip
RUN docker-php-ext-install zip

RUN echo 'alias phpunit="php vendor/bin/phpunit"' >> ~/.bashrc

RUN docker-php-ext-install opcache
RUN pecl install xdebug-3.1.2 && docker-php-ext-enable xdebug

RUN docker-php-ext-install pcntl
RUN docker-php-ext-enable pcntl
RUN pecl install pcov

RUN rm -rfv /tmp/*
RUN ln -sf /usr/share/zoneinfo/Europe/Madrid /etc/localtime

RUN apt-get -y update --fix-missing
RUN apt-get upgrade -y
WORKDIR /var/www/

COPY $PATH_APACHE2_SECURITY_CONFIG /etc/apache2/conf-available/security.conf
COPY $PATH_APACHE2_CONFIG /etc/apache2/apache2.conf
COPY $PATH_VHOST_CONFIG_DEFAULT /etc/apache2/sites-enabled/000-default.conf
COPY $PATH_PHP_INI_CONFIG /usr/local/etc/php/php.ini

RUN chown www-data:www-data -Rv /var/www/var/
RUN curl -sS https://get.symfony.com/cli/installer | bash -s - --install-dir /usr/local/bin