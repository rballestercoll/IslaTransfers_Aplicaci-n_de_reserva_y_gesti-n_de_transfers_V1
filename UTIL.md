📌 1. Accede al contenedor Docker

Abre una terminal y ejecuta:

```bash
docker exec -it mi_apache bash
```

Esto abrirá una terminal interactiva dentro del contenedor mi_apache.

📌 2. Instalar Composer dentro del contenedor

Ya dentro del contenedor, ejecuta los siguientes comandos:

```bash
apt-get update
apt-get install -y curl unzip
```

Ahora descarga e instala Composer dentro del contenedor:

```bash
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
```

📌 3. Comprobar la instalación

Verifica la instalación ejecutando:

```bash
composer --version
```

🔸 Método rápido (con Homebrew):
Si tienes Homebrew instalado, ejecuta en Terminal:

brew install composer
Verifica la instalación:

composer -v
🔸 Alternativa (Manual):
Ejecuta estos comandos uno a uno desde tu terminal:

php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer
rm composer-setup.php
Comprueba que funcione:

composer -v
