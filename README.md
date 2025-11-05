# 🎬 Catálogo de Títulos (CRUD Monolítico con Enfoque en PDO)

Este proyecto es la tercera pieza del portafolio y se centra en la demostración de un **CRUD (Crear, Leer, Actualizar, Eliminar) robusto, seguro y performante** dentro de una arquitectura **monolítica de PHP/HTML/CSS**.

El objetivo principal fue refactorizar una estructura inicial de proyecto escolar y transformarla en un módulo de gestión de datos listo para el mercado, priorizando la **seguridad transaccional** y el **diseño funcional**.

---

## ✨ Características Clave (Enfoque CRUD)

* **Seguridad de Datos (PDO):** Implementación rigurosa de sentencias preparadas utilizando la librería **PDO (PHP Data Objects)** en todas las operaciones de inserción, actualización y eliminación.
    * Esto garantiza una defensa robusta contra el ataque de seguridad número uno en aplicaciones web: la **Inyección SQL**.
* **Diseño Funcional y Estético (UI/UX):** Interfaz de usuario limpia, responsiva y con manejo de tarjetas (`card-based`) para la visualización de títulos. Se han añadido efectos **JavaScript** para mejorar la validación y la experiencia de interacción.
* **Operaciones Fundamentales (GET, POST, DELETE):** Implementación completa de las operaciones de alta demanda para la gestión de registros:
    * **GET (Lectura):** Despliegue dinámico de todos los registros del catálogo.
    * **POST (Creación):** Formulario seguro para la inserción de nuevos títulos.
    * **DELETE (Eliminación):** Mecanismo de eliminación directa y segura.
* **Manejo de Conexión:** Uso de un archivo `conexion.php` modular para la gestión eficiente y centralizada de la conexión a la base de datos MySQL.

---

## 🛡️ Declaración de Alcance y Prioridad Estratégica

Esta sección es crucial para contextualizar el proyecto y demostrar toma de decisiones madura.

**Evolución del Proyecto:**

La versión inicial de este proyecto incluía un sistema de autenticación (Login/Registro) desarrollado con el enfoque de **"proyecto escolar"** (utilizando `mysql_query` y almacenamiento de contraseñas inseguro).

Para cumplir con estándares profesionales y la prioridad del portafolio, se tomó la decisión estratégica de **eliminar por completo** dicho código obsoleto.

* **El Foco:** Se optó por **priorizar** la inversión de tiempo en la mejora de la **seguridad transaccional (PDO)** y la **calidad de la UI** para el CRUD, que es la funcionalidad de negocio central del proyecto.
* **Demostración de Madurez:** Al omitir la reconstrucción del módulo de autenticación (ya cubierto en el Proyecto 2), se demuestra la capacidad de un desarrollador para:
    1.  Identificar y rechazar código inseguro.
    2.  Priorizar el alcance para entregar la funcionalidad más valiosa (CRUD) con alta calidad y seguridad.

---

## 🚀 Instalación y Acceso (Modo Demo)

### Tecnologías

* **Backend:** PHP (Monolítico)
    * **Conexión:** PDO
* **Base de Datos:** MySQL
* **Frontend:** HTML5, CSS3, Bootstrap (Estructura) y JavaScript (Efectos y Validación).

### Pasos

1.  **Clonar el Repositorio**
2.  **Configurar Base de Datos:** Crear la BD e importar el script SQL de la tabla de títulos.
3.  **Verificar Conexión:** Asegúrate de que las credenciales en `conexion.php` sean válidas para tu entorno local.
4.  **Acceso Directo (Demo):** Inicia tu servidor Apache y accede directamente al archivo principal del catálogo:

    ```
    http://localhost/nombre_proyecto/titulos.php
    ```

    Esto permite la **evaluación inmediata** de las funcionalidades CRUD sin necesidad de registrarse.