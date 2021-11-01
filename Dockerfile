
FROM php:8.0-fpm-alpine

RUN cp /usr/bin/env /tmp

RUN cp /usr/bin/env /tmp

RUN docker-php-ext-install mysqli pdo pdo_mysql
    
WORKDIR /var/www
COPY . /var/www

EXPOSE 80

COPY .docker/nginx/nginx.conf /etc/nginx/nginx.conf