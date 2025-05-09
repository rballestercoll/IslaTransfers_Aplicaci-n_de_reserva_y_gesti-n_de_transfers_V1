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

---

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

## composer -v

APP_NAME="Isla Transfers"
APP_ENV=production
APP_KEY=base64:cxVhEET4Wcqx4EO7pGi2lt5Uf9bnnuDfv7p1AsZ31ro=
APP_DEBUG=true
APP_URL=https://fp064.techlab.uoc.edu/~uocx5/producto3

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=islatransfers_db
DB_USERNAME=user
DB_PASSWORD=userpass

---

docker exec -it mi_apache bash  
cd /var/www/html  
php artisan key:generate  
php artisan config:clear

---

docker-compose down
docker-compose build
docker-compose up -d

---

php artisan migrate:generate \
 --connection=mysql \
 --tables=transfer_reservas,transfer_precios,transfer_hotel \
 --path=database/migrations/imported

---

1. Seeder para el primer usuario admin

Es conveniente que al menos un usuario administrador exista desde el arranque. Crea un seeder que lo genere:

php artisan make:seeder AdminUserSeeder

<?php
// database/seeders/AdminUserSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::firstOrCreate(
            ['email' => 'admin@islatransfers.com'],
            [
                'name'     => 'Administrador',
                'password' => Hash::make('tu-contraseña-segura'),
            ]
        )->assignRole('admin');
    }
}
Y añádelo en tu DatabaseSeeder.php antes de RolesSeeder (para que el rol exista ya):

public function run(): void
{
    $this->call([
        RolesSeeder::class,
        AdminUserSeeder::class,
        // ZoneSeeder::class,
        // VehicleSeeder::class,
    ]);
}
Así, cuando hagas php artisan migrate:fresh --seed, tendrás un usuario admin@… con rol admin.
