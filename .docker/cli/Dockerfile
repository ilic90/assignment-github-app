FROM php:8.1-fpm

RUN docker-php-ext-install pdo pdo_mysql

RUN pecl install -o -f redis \
&&  rm -rf /tmp/pear \
&&  docker-php-ext-enable redis

RUN apt-get install curl

WORKDIR /var/www

RUN curl -O "https://getcomposer.org/download/1.10.17/composer.phar"
RUN chmod a+x composer.phar
RUN mv composer.phar /usr/local/bin/composer

WORKDIR /var/www/arena
