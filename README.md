# 🎬 ReelBox: Administrador de Catálogo de Películas

ReelBox es una aplicación web full-stack diseñada para la administración eficiente de un catálogo personal de películas. Este proyecto fue refactorizado desde una base de código PHP heredada a una arquitectura moderna, desacoplada y orientada a servicios, demostrando principios sólidos de desarrollo de API y manipulación dinámica del DOM. Demuestra la refactorización de una aplicación PHP heredada a una arquitectura moderna orientada a servicios (API).

Este proyecto transforma un sistema monolítico tradicional (que recarga la página con cada acción) en una aplicación web dinámica (estilo SPA) para la gestión de un catálogo de películas. Demuestra la separación de responsabilidades (Backend/Frontend), la manipulación asíncrona de datos y una fuerte mejora en la experiencia de usuario (UX).

## ✨ Características Clave (Enfoque CRUD)

*  Arquitectura Híbrida (Server-Side + Client-Side): La aplicación utiliza una carga inicial renderizada por el servidor (PHP while loop) para un Time-to-Content rápido, mientras que todas las operaciones posteriores (Crear, Eliminar) se manejan asíncronamente en el lado del cliente (JavaScript).
*  Respuestas JSON.
* CRUD Asíncrono (Fetch API): Todas las operaciones de modificación de datos utilizan la Fetch API de JavaScript para comunicarse con el backend sin necesidad de recargar la página.
* UI Reactiva con SweetAlert2: Se reemplazaron las alertas y confirmaciones nativas del navegador (alert(), confirm()) por modales interactivos y estéticos de SweetAlert2, mejorando drásticamente la UX.
* Persistencia de Estado en Cliente (localStorage): La funcionalidad "Visto" se gestiona 100% en el cliente, utilizando localStorage para mantener el estado de la UI entre sesiones sin consultar la base de datos.
* Modularidad de Código: El proyecto está estructurado con una separación clara de archivos por responsabilidad:
    + index.php (Vista/Cliente)
    + api/conexion.php (Configuración de BD)
    + api/peliculas.php (Controlador de API)
    + assets/js/main.js (Lógica CRUD)
    + assets/js/visto.js (Lógica de UI)
    + assets/css/styles.css (Estilos)

---

## 🛠️ Stack Tecnológico
Este proyecto utiliza un stack LAMP modernizado, enfocado en la modularidad.

### Backend y Base de Datos

* PHP: Como lenguaje principal para la lógica de negocio y el endpoint de la API.
* MySQL: Base de datos relacional para la persistencia de datos.
* API RESTful: Un endpoint único (api/peliculas.php) que maneja métodos HTTP (POST, DELETE) y responde con JSON.
* MySQLi (Orientado a Objetos): Extensión de PHP para la interacción segura y moderna con la base de datos.

### Frontend (Cliente)

* HTML5 y PHP: Utilizados en index.php para la renderización híbrida.
* CSS3: Estilos personalizados y modulares (assets/css/styles.css).
* JavaScript (ES6+): Modularizado (assets/js/) para manejar toda la lógica del cliente, incluyendo:
* Fetch API: Para todas las solicitudes asíncronas.
* Manipulación del DOM: Para la interactividad de la UI.
* LocalStorage API: Para la persistencia del estado "Visto".
* SweetAlert2: Librería externa para una UX mejorada en modales y notificaciones.
* TailwindCSS (CDN): Utilizado para clases de utilidad rápidas (como en los botones de acción y modales) sobre los estilos CSS base.

### Entorno de Desarrollo
* XAMPP: Entorno de desarrollo local Apache/MySQL/PHP.
* Git & GitHub: Control de versiones.

## 🚀 Instalación y Puesta en Marcha

### Requisitos:
Un entorno de servidor local como XAMPP (Apache, MySQL, PHP).

### Pasos:

1. Clonar el Repositorio:
Clona el proyecto dentro de tu directorio de trabajo del servidor local (ej. C:\xampp\htdocs).
git clone [https://github.com/Alejandro-dab/Reelbox-Catalogo_peliculas.git]

2. Crear la Base de Datos:
Crea una nueva base de datos llamada eqh.
Selecciona la base de datos eqh y ve a la pestaña "Importar".
Importa el archivo bd/eqh.sql para crear la tabla Peliculas y poblarla con datos de ejemplo.

3. Ajustar api/conexion.php:
Abre el archivo api/conexion.php.
Confirma que las credenciales ($host, $user, $password, $db_name) coinciden con tu configuración de MySQL. (Por defecto en XAMPP, $user = "root" y $password = "").

4. Inicia los servicios de Apache y MySQL en XAMPP.
Navega a [http://localhost/ReelBox/index.php#]
