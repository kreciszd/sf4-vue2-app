FROM thecodingmachine/php:7.2-v2-apache-node10

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

RUN touch /usr/local/etc/php/conf.d/php.ini \
    && echo "memory_limit = 2048M;" >> /usr/local/etc/php/conf.d/php.ini
