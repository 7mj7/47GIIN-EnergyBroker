# Configuración de Autenticación

## FilamentShield
El proyeco utiliza FilamentShield para la gestión de roles y permisos.

### Credenciales Iniciales
Tras la instalación, se crea automáticamente:

- **Usuario Administrador**
  - Email: admin@example.com
  - Role: super_admin
  - Password: password

### Pasos Post-Instalación Obligatorios
1. Acceder al sistema con las credenciales por defecto
2. Cambiar inmediatamente:
   - El email del administrador (no usar admin@example.com en producción)
   - La contraseña del administrador
3. Crear usuarios adicionales según necesidad
4. Configurar roles y permisos específicos

### ⚠️ Consideraciones de Seguridad
- No mantener el email por defecto (admin@example.com)
- No dejar la contraseña por defecto
- Realizar la configuración de roles inmediatamente después de la instalación
- Documentar cualquier cambio en la estructura de permisos

### Roles Predefinidos
- super_admin: Acceso completo al sistema