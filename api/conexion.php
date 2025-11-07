<?php
// conexion.php FINAL (PARA RAILWAY Y LOCALHOST)

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Leemos la variable DB_HOST de Railway
$DB_HOST_RAILWAY = getenv('DB_HOST');

if ($DB_HOST_RAILWAY) {
    // ESTAMOS EN RAILWAY (PRODUCCIÓN)
    // Lee todas las variables de entorno de Railway
    $DB_HOST = $DB_HOST_RAILWAY;
    $DB_USER = getenv('DB_USER');
    $DB_PASS = getenv('DB_PASS');
    $DB_NAME = getenv('DB_NAME');
    $DB_PORT = (int)getenv('DB_PORT'); // Convertir a entero

} else {
    // ESTAMOS EN LOCALHOST
    // Usa tus credenciales locales (las que usas en Workbench)
    $DB_HOST = '127.0.0.1'; // O 'localhost'
    $DB_USER = 'root';      // Tu usuario local
    $DB_PASS = 'root';          // Tu contraseña local (si no tienes, déjala vacía)
    $DB_NAME = 'Peliculas';     // El nombre de tu DB local
    $DB_PORT = 3306;        // Puerto MySQL por defecto
}

// 2. Conectamos usando las variables correctas
$conexion = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME, $DB_PORT);

// 3. Verificamos la conexión
if (!$conexion) {
    die("Error al conectarse a la base de datos: " . mysqli_connect_error());
}
?>