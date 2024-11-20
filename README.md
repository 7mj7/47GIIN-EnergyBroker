# EnergyBroker

Sistema de Gestión Comercial para Empresas Intermediarias de Energía

## Descripción del Proyecto

**Este proyecto ha sido desarrollado como parte de la asignatura 47GIIN - Proyecto de Ingeniería del Software del Grado en Ingeniería Informática de la Universidad Internacional de Valencia.**

EnergyBroker es una plataforma web desarrollada con Laravel y FilamentPHP que permite gestionar la actividad comercial de empresas intermediarias de energía. El sistema centraliza la información de clientes, contratos y equipos de ventas, facilitando la supervisión y la toma de decisiones.

### Características principales:

- Control de acceso basado en roles
- Gestión de usuarios y equipos de ventas 
- Gestión de contratos de electricidad y gas
- Descarga automática de precios OMIE
- Panel de administración con FilamentPHP

## Requisitos

- PHP 8.2 o superior
- Composer
- MySQL 8.0 o superior
- Node.js y NPM
- Git

## Instalación

1. Clonar el repositorio:
```bash
git clone https://github.com/7mj7/47GIIN-EnergyBroker.git
cd energybroker
```

2. Instalar dependencias PHP:
```bash
composer install
```

3. Copiar el archivo de configuración:
```bash
cp .env.example .env
```

4. Configurar las variables de entorno en el archivo .env:
```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=energybroker
DB_USERNAME=root
DB_PASSWORD=
```

5. Generar la clave de la aplicación:
```bash
php artisan key:generate
```

6. Ejecutar las migraciones y seeders:
```bash
php artisan migrate --seed
```

7. Instalar dependencias JavaScript y compilar los assets:
```bash
npm install
npm run dev
```

8. Iniciar el servidor de desarrollo:
```bash
php artisan serve
```

La aplicación estará disponible en http://localhost:8000