# Aplicación de Reserva y Gestión de Transfers

## Descripción del Proyecto

Esta aplicación web permite la reserva y gestión de transfers para la empresa **Isla Transfers**, que realiza traslados de viajeros entre el aeropuerto y los hoteles de la isla. La plataforma digitaliza la gestión de reservas, permitiendo que los clientes particulares y corporativos (hoteles) reserven y consulten sus traslados de manera sencilla.

### Características principales

- Registro y autenticación de usuarios.
- Gestión de reservas con generación de localizadores únicos.
- Panel de administración para gestión de reservas.
- Visualización de reservas en vista diaria, semanal y mensual en formato calendario.
- Panel de usuario con historial de reservas y edición de perfil.
- Restricciones de tiempo en las reservas (mínimo 48h de antelación).
- Base de datos MySQL para la gestión de usuarios, reservas y vehículos.

## Tecnologías Utilizadas

- **PHP** (sin Laravel)
- **MySQL**
- **Docker**
- **Git**
- **HTML/CSS/JavaScript** para el frontend
- **Apache** como servidor web

## Instalación y Configuración

### 1. Clonar el Repositorio

```bash
  git clone https://github.com/rballestercoll/IslaTransfers_Aplicaci-n_de_reserva_y_gesti-n_de_transfers_V1.git
  cd repo-isla-transfers
```

### 2. Configurar el Archivo de Conexión a la Base de Datos

Editar el archivo `Database.php` y modificar las credenciales para que coincidan con la configuración del contenedor MySQL.

### 3. Importar la Base de Datos

Cuando tengas el servidor, la base de datos y PHPMyAdmin levantados, desde PHPMyAdmin importa la Base de Datos, llamada UOC_transfers-1-1.sql alojada en el siguiente directorio:

```bash
../IslaTransfers_PHP/config/UOC_transfers-1-1.sql
```

## Uso con Docker

### 1. Construir y Levantar los Contenedores

Asegúrate de tener Docker y Docker Compose instalados. Luego, ejecuta:

```bash
docker-compose up -d --build
```

Esto creará los contenedores necesarios para MySQL, Apache y PHP.

### 2. Verificar los Contenedores Activos

```bash
docker ps
```

Debes ver contenedores corriendo para la base de datos y la aplicación PHP.

### 3. Acceder a la Aplicación

Una vez los contenedores estén en ejecución, puedes acceder a la aplicación desde tu navegador en:

```bash
http://localhost
```

### 4. Acceder al gestor de bases de Datos PHPMyAdmin

Una vez los contenedores estén en ejecución, puedes acceder a la aplicación desde tu navegador en:

```bash
http://localhost:8080
```

## Comandos Adicionales

### Detener los Contenedores

```bash
docker-compose down
```

### Reiniciar la Aplicación

```bash
docker-compose restart
```

### Ver Logs de Apache o MySQL

```bash
docker logs -f isla-transfers-apache
```

```bash
docker logs -f isla-transfers-mysql
```

## Contribución

Si deseas contribuir a este proyecto, por favor sigue estos pasos:

1. Realiza un **fork** del repositorio.
2. Crea una nueva rama con tu funcionalidad:
   ```bash
   git checkout -b mi-nueva-funcionalidad
   ```
3. Realiza cambios y confirma los commits:
   ```bash
   git commit -am "Agregada nueva funcionalidad"
   ```
4. Sube la rama a GitHub y crea un Pull Request:
   ```bash
   git push origin mi-nueva-funcionalidad
   ```

## Licencia

Este proyecto está bajo la licencia MIT. Puedes utilizarlo y modificarlo libremente.
