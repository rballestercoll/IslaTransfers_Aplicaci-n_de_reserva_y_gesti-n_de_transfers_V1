# Usa la imagen oficial de PHP 8.1 con Apache
FROM php:8.1-apache

# Instala dependencias y extensiones necesarias
RUN apt-get update \
    && apt-get install -y libzip-dev libpng-dev libonig-dev zip unzip git \
    && docker-php-ext-install pdo_mysql zip mbstring exif pcntl \
    && a2enmod rewrite

# Copia configuración personalizada de Apache (usa DocumentRoot /public)
COPY ./apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Copia los archivos de la aplicación Laravel
WORKDIR /var/www/html
COPY ./www/isla-transfers-laravel /var/www/html

# Asigna permisos adecuados para Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Expone el puerto 80 (por si se lanza fuera de Docker Compose)
EXPOSE 80

# Comando por defecto
CMD ["apache2-foreground"]
