# Extensión PCNTL (Process Control)

## ¿Qué es PCNTL?
PCNTL (Process Control) es una extensión de PHP que permite la gestión de procesos en sistemas Unix. Esta extensión es fundamental para ejecutar tareas en segundo plano y manejar procesos de manera eficiente.

## Instalación

1. Instalar la extensión PCNTL:
```bash
sudo apt-get install php8.2-pcntl
```

## Configuración

1. Habilitar la extensión:
```bash
sudo phpenmod pcntl
```
2. Editar php.ini:
```bash
sudo nano /etc/php/8.2/fpm/php.ini
```
3. Asegurarse que las funciones PCNTL no estén deshabilitadas:
```ini
disable_functions =
```
4. Reiniciar PHP-FPM:
```bash
sudo systemctl restart php8.2-fpm
```
