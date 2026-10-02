<?php
//Si la sesión no esta iniciada, entonces iniciala
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//Lectura de la variable DB_HOST de Render
$DB_HOST = getenv('DB_HOST');

//Si la variable de Render es true usamos todas sus variables
if ($DB_HOST) {
    //?Variables inyectadas de Render a Docker en tiempo de ejecución 
    $DB_USER = getenv('DB_USER');
    $DB_PASS = getenv('DB_PASS');
    $DB_NAME = getenv('DB_NAME');
    $DB_PORT = (int)getenv('DB_PORT'); // Convertir a entero
    $SSL = getenv('DB_SSL') === 'true'; //?Aiven exige SSL

} else {
    //En caso contrario, usaremos las variables de localhost
    $DB_HOST = '127.0.0.1'; //O 'localhost'
    $DB_USER = 'root';      //Usuario local
    $DB_PASS = 'root';          //Contraseña local (si no tiene, se déja con puras comillas)
    $DB_NAME = 'eqh';     //DB local
    $DB_PORT = 3306;        //Puerto MySQL por defecto
}

//mysqli_init + ssl_init + real_connect permiten activar SSL
//? mysqli_connect no puede hacerlo por si solo
if($SSL){
    //Inicialización del objeto de conexión en memoria 
    $conexion = mysqli_init(); 

    //Configuración de entorno SSL sin certificados locales
    //? Al pasar los parametros como NULL, no validamos ningún certificado especifico
    //? pero mantenemos la compatibilidad con SSL
    mysqli_ssl_set($conexion, NULL, NULL, NULL, NULL, NULL);

    //Utilizamos las variables y ejecutamos la conexión 
    mysqli_real_connect(
        $conexion, 
        $DB_HOST, 
        $DB_USER, 
        $DB_PASS, 
        $DB_NAME, 
        $DB_PORT, 
        NULL, 
        MYSQLI_CLIENT_SSL//Activar el cifrado
    );
}else {
    //Conexión local sin cifrar
    $conexion = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME, $DB_PORT);
}

if(!$conexion){ //Si la conexion falla
    die('Error al conectarse a la base de datos'.mysqli_connect_error());
}
?>