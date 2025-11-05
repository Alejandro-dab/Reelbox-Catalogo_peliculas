<?php
// Configuración de la base de datos
$host = "localhost";
$user = "root";
// CONTRASEÑA ACTUALIZADA (Según tu captura 'image_2603e8.png')
$password = "root"; 
$db_name = "eqh"; // Nombre de la base de datos

// Establecer la conexión
$conexion = @new mysqli($host, $user, $password, $db_name);

// Verificar la conexión y salir si hay error
if ($conexion->connect_error) {
    die("<h1>Error de Conexión a la Base de Datos</h1><p>Verifica:</p><ul><li>Que el servidor de MySQL (XAMPP/WAMP) esté corriendo.</li><li>Que la base de datos '{$db_name}' exista.</li><li>Que el usuario ('{$user}') y la contraseña ('{$password}') sean correctos en <b>api/conexion.php</b>.</li></ul><p>Detalle del error: " . $conexion->connect_error . "</p>");
}

// Establecer el charset
$conexion->set_charset("utf8mb4");

// ¡NO DEBE HABER NINGÚN 'ECHO' AQUÍ!
?>