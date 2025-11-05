<?php
// Incluimos la conexión. Si falla, el script muere en conexion.php
include("api/conexion.php");

// 1. Uso de sintaxis mysqli orientada a objetos para la consulta
$query = "SELECT id_peli, nombre_peli, imagen_url_peli, sinopsis_peli FROM Peliculas ORDER BY nombre_peli ASC";
// Ejecutar la consulta
$result = $conexion->query($query);

// Verificar si la consulta falló (aunque la conexión esté viva)
if ($result === false) {
    die("<h1>Error en la Consulta SQL</h1><p>Asegúrate de que la tabla 'Peliculas' existe y los nombres de las columnas son correctos.</p><p>Detalle: " . $conexion->error . "</p>");
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>ReelBox - Catálogo</title>
    <!-- Se recomienda usar Tailwind CSS como definimos, pero mantenemos tus estilos y enlaces externos por ahora -->
    <link rel="stylesheet" type="text/css" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/887a835504.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Zen+Antique&display=swap" rel="stylesheet">
    
    <!-- Agregamos el script de SweetAlert2 y estilos de Tailwind (si aún los necesitas) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.tailwindcss.com"></script> 
</head>
<body>
    <header></header>
    <h1 class="animated-text">Títulos</h1>
    <main id="contenido_principal">
        <div class="lista_contenido">
            <div class="movie-list">
                
                <!-- Botón de Agregar (Redirige al nuevo frontend basado en JS) -->
                <div class="movie">
                    <!-- Ahora el botón de agregar llama a la función JS showAddForm() -->
                    <a href="#" onclick="showAddForm()"> 
                        <div class="top-button">
                            <div class="movie-poster">
                                <img src="assets/img/icon_añadir_1.png" alt="Agregar Título" class="agregar">
                            </div>
                        </div>
                        <div class="movie-info">
                            <h3 class="movie-title">Agregar</h3>
                            <p class="movie-synopsis">Haz clic para agregar título</p>
                        </div>
                    </a>
                </div>

                <!-- 2. Loop para mostrar las películas usando mysqli orientada a objetos -->
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <div class="caja_contenido" data-id="<?php echo $row['id_peli']; ?>">
                        <div class="movie-actions">
                            
                            <!-- Checkbox Visto -->
                            <div class="flex items-center space-x-1 bg-gray-700 p-1 rounded-md text-white text-sm">
                                <!-- 2. Quitamos 'disabled' y añadimos 'onchange' -->
                                <input type="checkbox" data-peli-id="<?php echo $row['id_peli']; ?>" class="casilla" 
                                    onchange="handleVisto(<?php echo $row['id_peli']; ?>, this.checked)">
                                <span>Visto</span>
                            </div>

                            <!-- Botón de Eliminar (Llama a una función JS para usar SweetAlert y la API) -->
                            <button onclick="handleDelete(event, <?php echo $row['id_peli']; ?>, '<?php echo htmlspecialchars($row['nombre_peli'], ENT_QUOTES); ?>')" 
                                class="bg-red-600 hover:bg-red-700 text-white p-2 rounded-full transition duration-150 shadow-md">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                        
                        <div class="movie" onclick="handleViewDetails(<?php echo $row['id_peli']; ?>, '<?php echo htmlspecialchars($row['nombre_peli'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($row['sinopsis_peli'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($row['imagen_url_peli'] ?: 'https://placehold.co/250x150/2563eb/ffffff?text=No+Img', ENT_QUOTES); ?>')">
                            <!-- Usamos URL para la imagen -->
                            <img src="<?php echo htmlspecialchars($row['imagen_url_peli'] ?: 'https://placehold.co/250x150/2563eb/ffffff?text=No+Img'); ?>" 
                                alt="Pelicula" class="movie-poster" 
                                onerror="this.onerror=null;this.src='https://placehold.co/250x150/4b5563/ffffff?text=No+Image';">
                            <div class="movie-info">
                                <h3 class="movie-title"><?php echo htmlspecialchars($row['nombre_peli']); ?></h3>
                                <p class="movie-synopsis"><?php echo htmlspecialchars($row['sinopsis_peli']); ?></p>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                
            </div>
        </div>
    </main>

<script src="assets/js/visto.js" defer></script>
<script src="assets/js/main.js" defer></script>
</body>
</html>