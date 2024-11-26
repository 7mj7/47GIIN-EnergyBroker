# Configuración del Sistema de Correo Electrónico

## Proveedor SMTP
El sistema requiere la configuración de un servidor SMTP para el envío de correos electrónicos.

## Variables de Entorno
Configurar las siguientes variables en el archivo `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mail.com
MAIL_PORT=587
MAIL_USERNAME=tu_correo@mail.com
MAIL_PASSWORD=tu_contraseña
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=tu_correo@mail.com
MAIL_FROM_NAME="${APP_NAME}"
```

## Verificación de la Configuración SMTP

Para verificar que la configuración del correo funciona correctamente, sigue estos pasos:
### 1. Acceder a Tinker
Abre una terminal en la raíz del proyecto y ejecuta:
```bash
php artisan tinker
```
### 2.  Enviar correo de prueba
Una vez en Tinker, ejecuta el siguiente código:
```php
Mail::raw('Correo de prueba', function($message) {
    $message->to('correo_destino@ejemplo.com')
            ->subject('Prueba de configuración SMTP');
});
```
