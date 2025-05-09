# Usa la imagen oficial de PHP 8.1 con Apache
<<<<<<< HEAD
FROM php:8.2-apache
=======
FROM php:8.1-apache
>>>>>>> origin/PaulaC2

# Instala dependencias y extensiones necesarias
RUN apt-get update \
    && apt-get install -y libzip-dev libpng-dev libonig-dev zip unzip git \
    && docker-php-ext-install pdo_mysql zip mbstring exif pcntl \
    && a2enmod rewrite

# Copia los archivos de la aplicación y establece permisos
WORKDIR /var/www/html
COPY ./www/isla-transfers-laravel /var/www/html
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expone el puerto 80
EXPOSE 80

# Comando por defecto (ya lo maneja Dockerfile de php:apache)
CMD ["apache2-foreground"]