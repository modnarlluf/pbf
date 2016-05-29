FROM php:7-cli

ENV WORK_DIR=/srv/pbf

RUN apt-get update && apt-get install -y curl git unzip
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin

RUN mv /usr/local/bin/composer.phar /usr/local/bin/composer

RUN mkdir -p $WORK_DIR

RUN docker-php-ext-install pcntl sockets

WORKDIR $WORK_DIR
CMD ["php", "bin/bot"]
