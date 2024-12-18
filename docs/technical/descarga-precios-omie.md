# Componentes Principales

## 1. Comando Artisan

// app/Console/Commands/OmieDescargarPreciosHorarios.php

Este comando personalizado maneja la ejecución programada de la descarga de precios. Se puede ejecutar mediante:

```bash
php artisan omie:descargar-precios
```

## 2. Modelo

// app/Models/PrecioHorarioMercadoDiario.php

Gestiona la interacción con la tabla de la base de datos que almacena los precios horarios.

## 3. Servicio

// app/Services/PreciosHorariosMercadoDiarioService.php

Contiene la lógica de negocio para la descarga y procesamiento de datos de OMIE.

## 4 Programación de Tareas
En routes/console.php se define la programación de la tarea automatizada. 
El comando se puede programar para ejecutarse en intervalos específicos usando el programador de tareas de Laravel:
```php
// routes/console.php
$schedule->command('omie:descargar-precios')->dailyAt('01:00');
```

## 5 Uso

### Para ejecutar el proceso manualmente
Esto descarga los Precios de mañana
```bash
php artisan omie:descargar-precios-horarios
```

### Para descargar los precios de un día específico

Para descargar Precios de un día Específico, puedes hacerlo proporcionando la fecha en el formato YYYYMMDD. 
Por ejemplo, para descargar los precios del 20 de agosto de 2024, utiliza:

```bash
php artisan omie:descargar-precios-horarios 20240820
```

### Verificar que la tarea está programada correctamente:
```bash
php artisan schedule:list
```