PHP Bot Framework
===

This project provides a framework for building bots with php.

It's currently unix-only as only pcntl is supported for multitasking.

Requirements
---

- PHP 7
- pcntl

Or Docker

Install
---

First of all, you'll need to install dependencies using composer

### Local
```sh
$ # Install composer
$ curl -Ss https://getcomposer.org/installer |php -- --install-dir=/usr/local/bin
$ mv /usr/local/bin/composer.phar /usr/local/bin/composer
$ # Then install dependencies
$ composer install
```

### Docker
```sh
$ docker-compose up -d
$ docker exec -it pbf_php_1 bash
# composer install
```

Usage
---

Well ... It's not working yet.
