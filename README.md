<p align="center"><img width="400" height="200" alt="Captura de pantalla 2026-03-24 164721" src="https://github.com/user-attachments/assets/caca9021-e495-4e47-8c5d-2a49858284e7" /></p>

# Conexion EcoRisaralda

Conexión EcoRisaralda es un sistema de tipo web de EcoTurismo que está dedicado a dar a conocer los diferentes lugares naturales más atractivos del departamento de Risaralda.
Las funciones de los usuarios se basan en tres roles diferentes:
Administrador, Operador y Turista.
El acceso al sistema completo se da por módulos de registro e inicio de sesión, los usuarios comunes normalmente tendrán el rol de turista y con este tendrán la posibilidad de acceder a información confiable de los sitios eco turísticos que tenemos registrados, teniendo la opción, también de guardar sus sitios favoritos, puntuar y comentar.

## Objetivo del sistema
Desarrollar un sistema web que permita gestionar y promover el ecoturismo en Risaralda, brindando a los usuarios una plataforma donde puedan registrarse, personalizar su perfil, explorar eventos y sitios turísticos según sus preferencias, facilitando así una experiencia interactiva, segura y adaptada a sus intereses.

## Características principales

- Registro e inicio de sesión de usuarios
- Gestión de perfil (foto, nombre, correo, contraseña)
- Exploración de destinos ecoturísticos
- Publicación y visualización de eventos
- Personalización de preferencias del usuario
- Recomendaciones basadas en intereses

## Tecnologías utilizadas
**Backend:**
- PHP 8.2.12
- Framework Laravel 12
- ORM: Eloquent
  
**Frontend:**
- JavaScript
- React (con Vite como herramienta de construcción y entorno de desarrollo)

**Entorno de ejecución y gestión de paquetes:**
- Node.js
- npm
  
**Base de datos:**
- MySQL
  
**Control de versiones:**
- GitHub
- Git



## Roles del sistema
La plataforma EcoRisaralda ofrece diversas funcionalidades orientadas a mejorar la experiencia del usuario y la gestión del ecoturismo en la región.

**Funcionalidades del Usuario**
- Registro e inicio de sesión
- Exploración de sitios ecoturísticos
- Guardado de sitios en favoritos
- Consulta de historial de navegación
- Gestión de perfil (datos personales y preferencias)
- Comentarios y calificación de sitios
- Recepción de notificaciones del sistema

**Funcionalidades del Operador**
- Registro y publicación de sitios ecoturísticos
- Creación de eventos asociados a sus sitios
- Visualización de estadísticas de sus sitios
- Gestión y actualización de información de sus sitios
- Moderación y restricción de comentarios inapropiados

**Funcionalidades del Administrador**
- Gestión de sitios ecoturísticos
- Administración de usuarios
- Gestión de etiquetas o categorías
- Gestión de eventos
- Moderación y administración de comentarios

## Estructura del proyecto
```
backend/
└── Conexion-EcoRisaralda/
    ├── app/                    # Lógica principal (controladores, modelos, etc.)
    ├── bootstrap/              # Inicialización del framework
    ├── config/                 # Archivos de configuración
    ├── database/               # Migraciones, seeders y factories
    ├── public/                 # Punto de entrada (index.php) y archivos públicos
    ├── resources/              # Vistas, estilos y assets
    ├── routes/                 # Definición de rutas
    ├── storage/                # Logs, caché y archivos generados
    ├── tests/                  # Pruebas del sistema
    ├── vendor/                 # Dependencias de Composer
    │
    ├── .editorconfig           # Configuración del editor
    ├── .env                    # Variables de entorno
    ├── .env.example            # Ejemplo de variables
    ├── .gitattributes          # Configuración de Git
    ├── .gitignore              # Archivos ignorados
    │
    ├── artisan                 # CLI de Laravel
    ├── composer.json           # Dependencias PHP
    ├── composer.lock           # Versiones exactas
    │
    ├── package.json            # Dependencias Node.js
    ├── package-lock.json       # Versiones exactas Node
    │
    ├── phpunit.xml             # Configuración de pruebas
    ├── postcss.config.js       # Configuración de PostCSS
    ├── tailwind.config.js      # Configuración de Tailwind
    ├── vite.config.js          # Configuración de Vite
    │
    ├── create_admin.php        # Script para crear administrador
    ├── create_admin_simple.php # Script alternativo
    ├── reset_db.php            # Reinicio de base de datos
    │
    ├── test_login.html         # Prueba de interfaz
    ├── test_login.php          # Prueba de autenticación
    │
    └── README.md               # Documentación del backend
```

```
frontend/
└── FrontEndEcoturismo/
    ├── node_modules/        # Dependencias instaladas
    ├── public/              # Archivos públicos
    ├── src/                 # Código fuente principal
    │
    ├── .env                 # Variables de entorno
    ├── .gitignore           # Archivos ignorados por Git
    │
    ├── index.html           # Archivo principal HTML
    ├── package.json         # Dependencias del proyecto
    ├── package-lock.json    # Versiones exactas de dependencias
    │
    ├── postcss.config.js    # Configuración de PostCSS
    ├── tailwind.config.js   # Configuración de Tailwind CSS
    ├── vite.config.js       # Configuración de Vite
```

## Arquitectura del sistema
El proyecto está dividido en dos partes principales:

**Backend:** Desarrollado con Laravel, encargado de la lógica del sistema, autenticación y gestión de datos.

**Frontend:** Desarrollado con Vite, Tailwind CSS y JavaScript, encargado de la interfaz de usuario.


## Instalación y configuración
Sigue los siguientes pasos para ejecutar el proyecto en tu entorno local.

**Estructura inicial**

Crea una carpeta principal que contenga:

```
proyecto/
├── backend/
└── frontend/
```

### Instalación del Backend
1. Ubícate en la carpeta del backend:
   
`cd backend`

2. Clona el repositorio:
   
`git clone https://github.com/CrisMonsalve348/Conexion-EcoRisaralda.git`

3. Entra a la carpeta del proyecto:
   
`cd Conexion-EcoRisaralda`

4. Instala las dependencias de PHP:
   
`composer install`

5. Instala dependencias de Node (mapa interactivo):
   
`npm install`

### Configuración del entorno
   
6. Crea el archivo `.env`:
- Copia el contenido de `.env.example`
- Pégalo en un nuevo archivo llamado `.env`
  
7. Genera la clave de la aplicación:
   
``php artisan key:generate``

### Configuración de la base de datos

El proyecto utiliza base de datos (MySQL).

1. Crea una base de datos en MySQL, por ejemplo:
   
`conexion_ecorisaralda`

2. Configura el archivo `.env`:
```   
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=conexion_ecorisaralda
DB_USERNAME=root
DB_PASSWORD=
```

3. Ejecuta las migraciones y seeders:
   
`php artisan migrate:fresh --seed`

### Ejecutar el servidor backend
`php artisan serve`

### Instalación del Frontend
1. Abre otra terminal y ubícate en la carpeta:
   
`cd frontend`

2. Clona el repositorio:
   
`git clone https://github.com/chrisdacel/FrontEndEcoturismo.git`

3. Entra a la carpeta del frontend:
   
`cd FrontEndEcoturismo`

4. Instala las dependencias:
   
`npm install`

### Ejecutar el frontend
`npm run dev`

## Acceso al sistema

Una vez ejecutado todo correctamente, accede desde tu navegador:

`http://localhost:5173/`

## Requisitos
- PHP >= 8.x
- Composer
- Node.js
- MySQL
- XAMPP o entorno similar


## API REST - Documentación
### URL Base
`http://localhost:8000/api`

### AUTENTICACIÓN

La API utiliza autenticación basada en Laravel Sanctum.

Header requerido para rutas protegidas:

`
Authorization: Bearer {token}
Accept: application/json
`

### ROLES DEL SISTEMA
**admin:** Control total

**operator:** Gestiona sus sitios

**user:**	Interactúa y comenta

**guest:**	Solo visualiza

### FORMATO DE RESPUESTAS
- Éxito
  
```
{
  "success": true,
  "message": "Operación exitosa",
  "data": {}
}
```

- Error
```  
{
  "success": false,
  "message": "Error en la operación"
}
```

### AUTENTICACIÓN
**Login**

POST `/api/login`

Inicia sesión.

**Body**
```
{
  "email": "usuario@email.com",
  "password": "123456"
}
```

**Positivo**
```
{
  "token": "access_token",
  "user": {
    "id": 1,
    "name": "Usuario",
    "role": "admin"
  }
}
```

**Negativo**
````
{
  "message": "Credenciales incorrectas"
}
````

**Logout**

POST `/api/logout`

Requiere autenticación.

**Registro**

POST `/api/register`

Crea un usuario.

**Recuperar contraseña**
----------------------------------------
| Método	| Endpoint                 |
|-----------|--------------------------|
| POST	    |  `/api/forgot-password`  |
| POST	    |  `/api/reset-password`   |
----------------------------------------

### SITIOS ECOTURÍSTICOS (PLACES)
**Obtener todos los sitios**

GET `/api/places`

Acceso público.

**Respuesta**
````
{
  "data": [
    {
      "id": 1,
      "name": "Cascada Verde",
      "municipio": "Santa Rosa",
      "rating": 4.7
    }
  ]
}
````

**Obtener sitio por ID***

GET `/api/places/{id}`

**Error**
````
{
  "message": "Sitio no encontrado"
}
````

**Crear sitio turístico**

POST `/api/places`

Roles: operator, admin

**Body**
````
{
  "name": "Reserva Natural",
  "description": "Turismo ecológico",
  "municipio_id": 3
}
````

**Sin permisos**
````
{
  "message": "No autorizado"
}
````

**Actualizar sitio**

PUT `/api/places/{id}`

Roles:

- admin
- operador propietario
  
**Eliminar sitio**

DELETE `/api/places/{id}`

**Sitios del usuario operador**

GET `/api/user-places`

Devuelve sitios creados por el operador.

### RESEÑAS (REVIEWS)
**Crear reseña**

POST `/api/places/{id}/reviews`

Usuario autenticado.
````
{
  "rating": 5,
  "comment": "Excelente experiencia"
}
````

**Editar reseña**

PUT ``/api/reviews/{id}``

**Eliminar reseña**

DELETE ``/api/reviews/{id}``

**Reaccionar a reseña**

POST ``/api/reviews/{id}/react``


### COMENTARIOS
**Crear comentario**

POST ``/api/places/{id}/comments``


**Editar comentario**

PUT ``/api/comments/{id}``

**Eliminar comentario**

DELETE ``/api/comments/{id}``

### FAVORITOS
**Agregar favorito**

POST ``/api/places/{id}/favorite``

**Eliminar favorito**

DELETE ``/api/places/{id}/favorite``

**Ver favoritos**

GET ``/api/favorites``

### PERFIL DE USUARIO
**Ver perfil**

GET ``/api/profile``

**Actualizar perfil**

PUT ``/api/profile``

**Cambiar contraseña**

POST ``/api/profile/password``

**Subir avatar**

POST ``/api/profile/avatar``

**Eliminar avatar**

DELETE ``/api/profile/avatar``

### NOTIFICACIONES
***Listar notificaciones**

GET ``/api/user/notifications``

**Marcar como leída**

POST ``/api/user/notifications/{id}/read``


**Archivar notificación**

POST ``/api/user/notifications/{id}/archive``

**Archivar todas**

POST ``/api/user/notifications/archive-all``

### EVENTOS
**Próximos eventos**

GET ``/api/events/upcoming``

**Evento específico**

GET ``/api/events/{id}``

**Crear evento en sitio**

POST ``/api/places/{id}/events``

### ADMINISTRADOR API

(Acceso exclusivo admin)

**Dashboard**

GET ``/api/admin/dashboard``

**Gestionar usuarios**
--------------------------------------------
| Método	 | Endpoint                    |
|------------|-----------------------------|
| GET        |	`/api/admin/users`         |
| POST       |	`/api/admin/users`         |
| GET        |	`/api/admin/users/{id}`    |
| PUT        |	`/api/admin/users/{id}`    |
| DELETE     | 	`/api/admin/users/{id}`    |
--------------------------------------------

**Gestionar sitios**
-------------------------------------
| Método  |	Endpoint                 |
|---------|--------------------------|
| GET	  | `/api/admin/places`      |
| PUT	  | `/api/admin/places/{id}` |
| DELETE  |	`/api/admin/places/{id}` |
--------------------------------------

**Moderar reseñas**
-----------------------------------------------------
| Método  |	Endpoint                                |
|---------|-----------------------------------------|
| GET	  | ``/api/admin/reviews``                  |
| POST    |	``/api/admin/reviews/{id}/restrict``    |
| POST    | ``/api/admin/reviews/{id}/unrestrict``  |
------------------------------------------------------

**Aprobar operadores**
--------------------------------------------------
| Método  |	Endpoint                             |
|---------|--------------------------------------|
| GET     |	``/api/admin/operators/pending``     |
| POST    |	``/api/admin/operators/{id}/approve``|
| POST    |	``/api/admin/operators/{id}/reject`` |
--------------------------------------------------

### OPERADOR TURÍSTICO API
**Estadísticas operador**

GET ``/api/operator/stats``

**Moderar reseñas propias**
------------------------------------------------------
| Método  |	Endpoint                                 |
|---------|------------------------------------------|
| GET     |	``/api/operator/reviews``                |
| POST    |	``/api/operator/reviews/{id}/restrict``  |
| POST    |	``/api/operator/reviews/{id}/unrestrict``|
------------------------------------------------------

### PREFERENCIAS Y RECOMENDACIONES
**Preferencias usuario**
--------------------------------------
| Método  |	Endpoint                  |
|---------|---------------------------|
| GET	  | ``/api/user/preferences`` |
| POST	  | ``/api/user/preferences`` |
---------------------------------------

**Recomendaciones**
GET ``/api/recommendations``

### SALUD DEL SISTEMA
**Health Check**

GET ``/api/health``

Verifica que la API esté activa.

### CÓDIGOS HTTP
--------------------------------
| Código  |	Significado        |
|---------|--------------------|
| 200     |	OK                 |
| 201     |	Creado             |
| 401     |	No autenticado     |
| 403     |	Prohibido          |
| 404     |	No encontrado      |
| 422     |	Error validación   |
| 500     |	Error servidor     |
--------------------------------

### ENDPOINTS PÚBLICOS

No requieren login:

- ``/api/places``
- ``/api/places/{id}``
- ``/api/events/upcoming``
- ``/api/recommendations``
- ``/api/register``
- ``/api/login``

## Autores

- **Cristian Monsalve**
   
  3146355214  

- **Cristian Acevedo**
  
  3502502052  

- **Jackeline Giraldo Gaviria**
  
  3018164826  
