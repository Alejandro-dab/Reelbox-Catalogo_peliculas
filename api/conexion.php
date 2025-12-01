<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//Lectura de la variable DB_HOST de Railway
$DB_HOST_RAILWAY = getenv('DB_HOST');

//Si la variable de Railway es true usamos todas sus variables
if ($DB_HOST_RAILWAY) {
    //Variables de entorno de Railway
    $DB_HOST = $DB_HOST_RAILWAY;
    $DB_USER = getenv('DB_USER');
    $DB_PASS = getenv('DB_PASS');
    $DB_NAME = getenv('DB_NAME');
    $DB_PORT = (int)getenv('DB_PORT'); // Convertir a entero

} else {
    //En caso contrario, usaremos las variables de localhost
    $DB_HOST = '127.0.0.1'; //O 'localhost'
    $DB_USER = 'root';      //Usuario local
    $DB_PASS = 'root';          //Contraseña local (si no tiene, se déja vacía)
    $DB_NAME = 'Peliculas';     //DB local
    $DB_PORT = 3306;        //Puerto MySQL por defecto
}

//Conexión con las variables elegidas
$conexion = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME, $DB_PORT);

//Verificación de la conexión
if (!$conexion) {
    die("Error al conectarse a la base de datos: " . mysqli_connect_error());
}
?>