FROM thecodingmachine/php:7.2-v2-apache

USER root
RUN apt-get update || apt-get update
RUN apt-get install -y \
        libssh-dev \
        libmcrypt-dev \
        librabbitmq-dev

RUN docker-php-ext-install bcmath
RUN docker-php-ext-install sockets
RUN docker-php-ext-install opcache
RUN docker-php-ext-enable amqp
