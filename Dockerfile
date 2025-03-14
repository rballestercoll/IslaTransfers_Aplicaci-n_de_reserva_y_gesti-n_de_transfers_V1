FROM php:8.2-apache

# Actualizamos índices e instalamos la extensión pdo_mysql
RUN apt-get update && \
    docker-php-ext-install pdo_mysql
