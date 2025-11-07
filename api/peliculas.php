<?php
// Incluimos la conexión desde la misma carpeta
include 'conexion.php';

// Establecer cabeceras para una respuesta JSON adecuada y permitir CORS
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Si es una petición OPTIONS, es preflight, respondemos con éxito y salimos
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

$method = $_SERVER['REQUEST_METHOD'];

// Función de respuesta uniforme
function response($status, $data = [], $message = null) {
    http_response_code($status);
    echo json_encode(['status' => $status, 'message' => $message, 'data' => $data]);
    exit();
}

// =========================================================================
// Ruteo y Lógica CRUD para la tabla Peliculas
// =========================================================================

switch ($method) {
    case 'GET':
        // ===================================
        // READ: Obtener Películas
        // ===================================
        $id = isset($_GET['id_peli']) ? intval($_GET['id_peli']) : 0;
        
        // Columnas a seleccionar de la tabla Peliculas
        $columns = "id_peli, nombre_peli, imagen_url_peli, sinopsis_peli";

        if ($id) {
            // Obtener una sola película
            $stmt = $conexion->prepare("SELECT $columns FROM Peliculas WHERE id_peli = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $pelicula = $result->fetch_assoc();

            if ($pelicula) {
                response(200, $pelicula);
            } else {
                response(404, [], "Película con ID $id_peli no encontrada.");
            }
        } else {
            // Obtener todas las películas
            $result = $conexion->query("SELECT $columns FROM Peliculas ORDER BY nombre_peli ASC");
            $peliculas = [];
            while ($row = $result->fetch_assoc()) {
                // Asegurar que la URL de la imagen tenga un valor por defecto si es nula
                $row['imagen_url_peli'] = $row['imagen_url_peli'] ?: 'https://placehold.co/100x150/2563eb/ffffff?text=No+Img';
                $peliculas[] = $row;
            }
            response(200, $peliculas);
        }
        break;

    case 'POST':
        // ===================================
        // CREATE: Añadir Película
        // ===================================
        $data = json_decode(file_get_contents("php://input"), true);
        
        if (empty($data['nombre_peli']) || empty($data['sinopsis_peli'])) {
            response(400, [], "El título y la sinopsis son campos obligatorios.");
        }

        $nombre_peli = $data['nombre_peli'];
        $imagen_url_peli = $data['imagen_url_peli'] ?? 'https://placehold.co/100x150/2563eb/ffffff?text=No+Img';
        $sinopsis_peli = $data['sinopsis_peli'];

        $stmt = $conexion->prepare("INSERT INTO Peliculas (nombre_peli, imagen_url_peli, sinopsis_peli) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nombre_peli, $imagen_url_peli, $sinopsis_peli);

        if ($stmt->execute()) {
            $id_insertado = $conexion->insert_id;
            response(201, ['id_peli' => $id_insertado, 'nombre_peli' => $nombre_peli], "Película creada con éxito.");
        } else {
            response(500, [], "Error al crear la película: " . $stmt->error);
        }
        break;

    case 'PUT':
        // ===================================
        // UPDATE: Actualizar Película
        // ===================================
        $data = json_decode(file_get_contents("php://input"), true);
        
        if (empty($data['id_peli']) || empty($data['nombre_peli']) || empty($data['sinopsis_peli'])) {
            response(400, [], "ID, título y sinopsis son obligatorios para la actualización.");
        }

        $id_peli = intval($data['id_peli']);
        $nombre_peli = $data['nombre_peli'];
        $imagen_url_peli = $data['imagen_url_peli'] ?? 'https://placehold.co/100x150/2563eb/ffffff?text=No+Img';
        $sinopsis_peli = $data['sinopsis_peli'];

        $stmt = $conexion->prepare("UPDATE Peliculas SET nombre_peli = ?, imagen_url_peli = ?, sinopsis_peli = ? WHERE id_peli = ?");
        $stmt->bind_param("sssi", $nombre_peli, $imagen_url_peli, $sinopsis_peli, $id_peli);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                response(200, [], "Película ID: $id_peli actualizada con éxito.");
            } else {
                response(404, [], "Película ID: $id_peli no encontrada o no se realizaron cambios.");
            }
        } else {
            response(500, [], "Error al actualizar la película: " . $stmt->error);
        }
        break;

    case 'DELETE':
        // ===================================
        // DELETE: Eliminar Película
        // ===================================
        $data = json_decode(file_get_contents("php://input"), true);
        $id_peli = isset($data['id_peli']) ? intval($data['id_peli']) : 0;
        
        if (!$id_peli) {
            response(400, [], "ID de película faltante.");
        }

        $stmt = $conexion->prepare("DELETE FROM Peliculas WHERE id_peli = ?");
        $stmt->bind_param("i", $id_peli);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                response(200, [], "Película ID: $id_peli eliminada con éxito.");
            } else {
                response(404, [], "Película ID: $id_peli no encontrada.");
            }
        } else {
            response(500, [], "Error al eliminar la película: " . $stmt->error);
        }
        break;

    default:
        response(405, [], "Método no permitido.");
        break;
}

$conexion->close();
?>