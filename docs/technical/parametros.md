# Documentación Técnica del Módulo de Parámetros

## Índice

1. [Introducción](#introducción)
2. [Descripción del Módulo](#descripción-del-módulo)
3. [Características Principales](#características-principales)
4. [Flexibilidad en la Gestión de Parámetros](#flexibilidad-en-la-gestión-de-parámetros)
5. [Estructura del Código](#estructura-del-código)
6. [Formularios y Validaciones](#formularios-y-validaciones)
7. [Funcionamiento](#funcionamiento)
8. [Tecnologías Utilizadas](#tecnologías-utilizadas)
9. [Pruebas](#pruebas)
10. [Conclusiones](#conclusiones)

---

## Introducción

El módulo de **Parámetros** es una parte esencial del sistema **EnergyBroker** que permite la gestión y configuración de parámetros globales de la aplicación. Este módulo facilita la personalización de aspectos fundamentales como datos fiscales y de contacto, asegurando la coherencia y precisión en la administración de contratos.

## Descripción del Módulo

El módulo de Parámetros permite a los administradores del sistema gestionar configuraciones clave que afectan el funcionamiento general de la aplicación. Está dividido en dos secciones principales:

- **Datos Fiscales:** Gestión de información fiscal de la empresa.
- **Datos de Contacto:** Administración de información de contacto para comunicación.

## Características Principales

- **Gestión de Datos Fiscales:** Permite la creación, edición y visualización de parámetros fiscales como nombre de la empresa, NIF, dirección, código postal, población y provincia.
- **Gestión de Datos de Contacto:** Facilita la administración de parámetros de contacto como teléfono y email.
- **Validaciones Automáticas:** Asegura que los datos ingresados cumplen con formatos y requisitos específicos.
- **Interfaz Intuitiva:** Proporciona una interfaz de usuario clara y estructurada para facilitar la gestión de parámetros.
- **Notificaciones:** Informa al usuario sobre el éxito de las operaciones de guardado.


## Flexibilidad en la Gestión de Parámetros

La **estructura de la tabla `parametros`** ha sido diseñada para ofrecer una gran flexibilidad, permitiendo añadir la cantidad de parámetros que sean necesarios sin requerir modificaciones en la estructura de la base de datos. Cada parámetro está asociado a un grupo específico mediante el campo `grupo`, lo que facilita su organización y categorización. Esta capacidad de agrupamiento permite gestionar de manera eficiente diferentes conjuntos de configuraciones relacionadas, simplificando así la administración y mantenimiento del sistema. Además, al utilizar un esquema dinámico, los administradores pueden introducir nuevos parámetros y grupos según las necesidades emergentes del proyecto, asegurando que el módulo de **Parámetros** se mantenga escalable y adaptable a futuras expansiones y requisitos funcionales.


## Estructura del Código

El módulo está implementado en la clase `Parametros` ubicada en `App\Filament\Admin\Pages\Parametros.php`. Utiliza componentes de FilamentPHP para construir la interfaz de gestión.

### **Clases y Traits Utilizados**

- **InteractsWithForms:** Para manejar la interacción con los formularios.
- **HasPageShield:** Para gestionar permisos de acceso a la página.
- **Filament\Pages\Page:** Clase base para la página de Filament.

### **Componentes Principales**

- **Sections:** Divide el formulario en "Datos Fiscales" y "Datos de Contacto".
- **TextInput y Select:** Utilizados para capturar y mostrar los parámetros.
- **Actions:** Botón para guardar configuraciones.

## Formularios y Validaciones

### **Datos Fiscales**

- **Nombre de la Empresa:** Campo obligatorio con un mínimo de 3 caracteres.
- **NIF:** Campo obligatorio con validación de formato específico.
- **Dirección, Código Postal, Población, Provincia:** Campos con validaciones para asegurar la integridad de los datos.

### **Datos de Contacto**

- **Teléfono:** Campo opcional con validación para números españoles.
- **Email:** Campo obligatorio con formato de email válido.

### **Reglas de Validación**

```php
public function getRules(): array
{
    return [
        'parametrosContacto.email' => [
            'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            'max:255'
        ],
        'parametrosContacto.telefono' => [
            'regex:/^(?:\+34|0034)?[6-9][0-9]{8}$/'
        ],
        'parametrosFiscales.nombre' => [
            'required',
            'string',
            'min:3',
            'max:255'
        ],
        'parametrosFiscales.nif' => [
            'required',
            'string',
            'regex:/^([ABCDEFGHJKLMNPQRSUVW])(\d{7})([0-9A-J])$|^([0-9]{8})([A-Z])$/'
        ],
        'parametrosFiscales.codigo_postal' => [
            'regex:/^[0-9]{5}$/'
        ]
    ];
}
```

### **Mensajes de Error Personalizados**

```php
public function getValidationMessages(): array
{
    return [
        // Parámetros Fiscales            
        'parametrosFiscales.nombre.min' => 'El nombre debe tener al menos 3 caracteres',
        'parametrosFiscales.nombre.required' => 'El nombre es obligatorio',
        'parametrosFiscales.nif.regex' => 'El NIF/CIF debe tener un formato válido',
        'parametrosFiscales.nif.required' => 'El NIF/CIF es obligatorio',
        'parametrosFiscales.codigo_postal.regex' => 'El código postal debe tener 5 dígitos',

        // Parámetros de Contacto
        'parametrosContacto.email.regex' => 'El formato del email no es válido',
        'parametrosContacto.telefono.regex' => 'El teléfono debe ser un número español válido',
    ];
}
```