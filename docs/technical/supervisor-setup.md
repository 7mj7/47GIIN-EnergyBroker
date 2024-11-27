# Configuración de Supervisor para EnergyBroker

## Índice
1. [Introducción](#introducción)
2. [Instalación](#instalación)
3. [Configuración](#configuración)
4. [Gestión de Workers](#gestión-de-workers)


## Introducción

Supervisor es una herramienta que permite monitorear y controlar procesos en sistemas Unix de manera automática. Su principal función es mantener los procesos en ejecución, reiniciarlos si fallan y proporcionar una interfaz simple para administrarlos. Es especialmente útil para asegurar que los servicios críticos de una aplicación se mantengan funcionando continuamente sin necesidad de intervención manual.

> **Nota**: Para el correcto funcionamiento de los workers es necesario tener instalada y configurada la extensión PCNTL. Consulta la [documentación de PCNTL](./extensions/pcntl.md) para más detalles.

## Instalación

1. Instalar Supervisor:
```bash
sudo apt-get update
sudo apt-get install supervisor
```
2. Verificar la instalación:
```bash
sudo supervisord -v
```

## Configuración

1. Configuración del Worker
Crear archivo de configuración para EnergyBroker:
```bash
sudo nano /etc/supervisor/conf.d/energybroker-worker.conf
```
2.Añadir la siguiente configuración (modificar segín corresponda):
```ini
[program:energybroker-worker]
process_name=%(program_name)s_%02d
command=php /ruta/a/tu/aplicacion/artisan queue:work
autostart=true
autorestart=true
user=www-data
numprocs=1
redirect_stderr=true
stdout_logfile=/var/log/supervisor/worker.log
stopwaitsecs=3600
```
Explicación de la Configuración
* **process_name**: Define el formato del nombre del proceso
* **command**: Comando para ejecutar el worker de Laravel
* **autostart**: Inicia automáticamente al arrancar Supervisor
* **autorestart**: Reinicia automáticamente si el proceso falla
* **user**: Usuario del sistema que ejecutará el proceso
* **numprocs**: Número de instancias del worker
* **redirect_stderr**: Redirige errores al archivo de log
* **stdout_logfile**: Ubicación del archivo de log
* **stopwaitsecs**: Tiempo de espera antes de forzar el cierre

## Gestión de Workers
**Comandos Básicos**
1. Recargar configuración:
```bash
sudo supervisorctl reread
sudo supervisorctl update
```
2. Ver estado de los workers:
```bash
sudo supervisorctl status
```
3. Iniciar/Detener/Reiniciar workers:
```bash
# Iniciar todos los workers
sudo supervisorctl start energybroker-worker:*

# Detener todos los workers
sudo supervisorctl stop energybroker-worker:*

# Reiniciar todos los workers
sudo supervisorctl restart energybroker-worker:*
```

## Visualización de Logs

1. Ver logs en tiempo real:
```bash
sudo supervisorctl tail energybroker-worker:energybroker-worker_00
```

2. Ver logs del supervisor:
```bash
sudo tail -f /var/log/supervisor/supervisord.log
```
