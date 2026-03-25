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

### Configuración del entorno (.env)
   
6. Crea el archivo `.env`:
- Copia el contenido de `.env.example`
- Pégalo en un nuevo archivo llamado `.env`
  
**Variables de entorno del Backend**

**Aplicación**
````
APP_NAME=Laravel
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost
ASSET_URL=http://localhost
FRONTEND_URL=http://localhost:5173
FRONTEND_URL_ALT=http://127.0.0.1:5173
````
---------------------------------------------------------------------
| Variable          |	Descripción                                  |
|-------------------|------------------------------------------------|
| APP_NAME          |	Nombre del proyecto                          |
| APP_ENV           |	Entorno (local, production)                  |
| APP_KEY           |	Clave de seguridad (se genera con artisan)   |
| APP_DEBUG         |	Muestra errores en desarrollo                |
| APP_URL           |	URL del backend                              |
| ASSET_URL         |	URL de recursos                              |
| FRONTEND_URL      |	URL principal del frontend                   |
| FRONTEND_URL_ALT  |	URL alternativa                              |
----------------------------------------------------------------------

**Localización**
````
APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US
````

---------------------------------------------------------
| Variable              |	Descripción                  |
|-----------------------|--------------------------------|
| APP_LOCALE            |	Idioma principal             |
| APP_FALLBACK_LOCALE   |	Idioma alternativo           |
| APP_FAKER_LOCALE      |	Idioma para datos de prueba  |
---------------------------------------------------------

**Mantenimiento**

``APP_MAINTENANCE_DRIVER=file``

------------------------------------------------------------
| Variable	             |  Descripción                     |
|------------------------|----------------------------------|
| APP_MAINTENANCE_DRIVER |	Controla el modo mantenimiento  |
------------------------------------------------------------

**Seguridad**

``BCRYPT_ROUNDS=12``

--------------------------------------------
| Variable       |	Descripción            |
|----------------|-------------------------|
| BCRYPT_ROUNDS  |	Nivel de encriptación  |
--------------------------------------------

**Logs**
````
LOG_CHANNEL=stack
LOG_STACK=single
LOG_LEVEL=debug
````
---------------------------------------------
| Variable     |	Descripción             |
|--------------|------------------------------
| LOG_CHANNEL  |	Canal de logs            |
| LOG_STACK    |	Tipo de almacenamiento   |
| LOG_LEVEL    |	Nivel de detalle         |
----------------------------------------------

**Base de datos**
````
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=conexion_ecorisaralda
DB_USERNAME=root
DB_PASSWORD=
````
-----------------------------------------------------
| Variable        | 	Descripción                 |
|-----------------|---------------------------------|
| DB_CONNECTION   |	Tipo de BD (mysql, sqlite)      |
| DB_HOST         |	Servidor                        |
| DB_PORT         |	Puerto                          |
| DB_DATABASE     |	Nombre de BD                    |
| DB_USERNAME     |	Usuario                         |
| DB_PASSWORD     |	Contraseña                      |
-----------------------------------------------------

**Sesiones**
````
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null
SESSION_SECURE_COOKIE=true
````
----------------------------------------------------
| Variable               |	Descripción            |
|------------------------|-------------------------|
| SESSION_DRIVER         |	Tipo de sesión         |
| SESSION_LIFETIME       |	Duración               |
| SESSION_ENCRYPT        |	Encriptación           |
| SESSION_PATH           |	Ruta                   |
| SESSION_DOMAIN         |	Dominio                |
| SESSION_SECURE_COOKIE  |	Seguridad de cookies   |
----------------------------------------------------

 **Sistema**
 ````
BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database
CACHE_STORE=database
````
-----------------------------------------
| Variable	            | Descripción    |
|-----------------------|----------------|
| BROADCAST_CONNECTION  |	Eventos      |
| FILESYSTEM_DISK       |	Archivos     |
| QUEUE_CONNECTION      |	Cola         |
| CACHE_STORE           |	Caché        |
------------------------------------------

**Redis / Memcached**

````
MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

````
-----------------------------------------
| Variable       |	Descripción         |
|----------------|----------------------|
| REDIS_HOST     |	Servidor Redis      |
| REDIS_PORT     |	Puerto              |
| MEMCACHED_HOST |	Servidor Memcached  |
-----------------------------------------

**Correo**
````
MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
````
------------------------------------------
| Variable          |	Descripción      |
|-------------------|--------------------|
| MAIL_MAILER       |	Método de envío  |
| MAIL_HOST         |	Servidor         |
| MAIL_PORT         |	Puerto           |
| MAIL_USERNAME     |	Usuario          |
| MAIL_PASSWORD     |	Contraseña       |
| MAIL_FROM_ADDRESS |	Correo remitente |
| MAIL_FROM_NAME    |	Nombre remitente |
------------------------------------------

**AWS (Opcional)**
````
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
````
--------------------------------------------
| Variable              |	Descripción    |
|-----------------------|------------------|
| AWS_ACCESS_KEY_ID     |	Clave AWS      |
| AWS_SECRET_ACCESS_KEY |	Clave secreta  |
| AWS_BUCKET            |	Almacenamiento |
--------------------------------------------

**Vite**

``VITE_APP_NAME="${APP_NAME}"``
------------------------------------------
| Variable       |	Descripción          |
|----------------|-----------------------|
| VITE_APP_NAME  |	Nombre para frontend |
------------------------------------------

**Generar clave de la app**

``php artisan key:generate``

**Configuración de la base de datos**

Crea una base de datos en MySQL, por ejemplo:

``conexion_ecorisaralda``

Ejecuta migraciones:

``php artisan migrate:fresh --seed``

### Ejecutar el backend**

``php artisan serve``


### Instalación del Frontend

Ubícate en la carpeta:

``cd frontend``

Clona el repositorio:

``git clone https://github.com/chrisdacel/FrontEndEcoturismo.git``

Entra al proyecto:

``cd FrontEndEcoturismo``

Instala dependencias:

``npm install``

### Configuración del Frontend (.env)

Crea un archivo .env en el frontend:

``VITE_API_URL=http://localhost:8000/api``

------------------------------------
| Variable     |	Descripción     |
|--------------|--------------------|
| VITE_API_URL |	URL del backend |
-------------------------------------

### Ejecutar el frontend
``npm run dev``

**Acceso al sistema**

``http://localhost:5173/``

## Requisitos
- PHP >= 8.x
- Composer
- Node.js
- MySQL
- XAMPP o entorno similar

## Configuración CORS
El sistema Conexión EcoRisaralda implementa configuración CORS (Cross-Origin Resource Sharing) en el backend desarrollado con Laravel.

Esto permite la comunicación segura entre el frontend (React) y el backend (API REST), incluso cuando están en diferentes dominios.

**Proposito**

CORS permite definir qué dominios pueden acceder al backend, evitando accesos no autorizados.

En este proyecto se utiliza junto con Laravel Sanctum para autenticación basada en cookies.

**Configuración principal**

Rutas protegidas
````
'paths' => [
    'api/*',
    'sanctum/csrf-cookie',
    'login',
    'logout',
    'user',
],
````
Define los endpoints donde se aplican las reglas CORS.

**Orígenes permitidos**
````
'allowed_origins' => [
    env('FRONTEND_URL'),
    env('FRONTEND_URL_ALT'),
],
````

Permite el acceso desde el frontend.

También puede configurarse con múltiples dominios usando:

``CORS_ALLOWED_ORIGINS=http://localhost:5173,http://127.0.0.1:5173``

**Métodos HTTP**
``'allowed_methods' => ['*'],``

Permite todos los métodos (GET, POST, PUT, DELETE).

**Headers**

``'allowed_headers' => ['*'],``

Permite todos los encabezados HTTP.

**Credenciales**

``'supports_credentials' => true,``

Permite enviar cookies y sesiones (necesario para Sanctum).

**Cache**

``'max_age' => 0,``

No guarda en caché las solicitudes preflight.

Esta configuración permite:

- Comunicación segura entre frontend y backend
- Autenticación con Laravel Sanctum
- Compatibilidad entre entornos (local y producción)


## Ejecutar pruebas
**Frontend (React)**

``npm test``

**Backend (Laravel)**

``php artisan test``

Estas pruebas incluyen validaciones de componentes, lógica de negocio y comunicación entre el cliente y el servidor.

### Tipos de pruebas implementadas

- Pruebas unitarias  
- Pruebas de integración  
- Pruebas de componentes  

Para más información, consultar la sección de **Pruebas** en la documentación del proyecto.

## Usuarios de prueba

Para facilitar la validación del sistema, se disponen los siguientes usuarios de prueba:
--------------------------------------------------------------------
| Rol       | Correo                    | Contraseña               |
|-----------|---------------------------|--------------------------|
| Admin     | admin@ecorisaralda.com    | admin@ecorisaralda.com   |
| Operador  | test@example.com          | password123              |
| Turista   | test2@example.com         | password123              |
--------------------------------------------------------------------

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
