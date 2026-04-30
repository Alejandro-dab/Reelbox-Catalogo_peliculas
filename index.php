<?php
//Se importa el modulo de conexión mediante una ruta absoluta
//"Se usa __DIR__ para construir una ruta estable al archivo de conexión."
require __DIR__ . '/api/conexion.php';  
//Esto evita problemas con rutas relativas o contexto de ejecución distinto

//Se define la consulta SQL con los campos necesarios
$query = "SELECT id_peli, nombre_peli, imagen_url_peli, sinopsis_peli FROM Peliculas ORDER BY nombre_peli ASC";
//Ejecuta la consulta sobre la conexión activa.
$result = $conexion->query($query);

//Verifica si la consulta falló 
if ($result === false) {
    error_log("Error SQL en index.php: " . $conexion->error); 
    die("<h1>Error del servidor</h1><p>No se pudo cargar el catálogo</p>"); 
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Meta de escalabilidad de pantalla -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Asegura compatibilidad en la codificación de caracteres -->
    <meta charset="UTF-8">
    <!-- Asegura compatibilidad con Internet Explorer usando el motor más moderno disponible -->
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    

    <title>ReelBox - Catálogo</title>
    <!-- Carga la hoja de estilos principal de la aplicación. -->
    <link rel="stylesheet" type="text/css" href="assets/css/styles.css">
    <!-- Carga de Fontawesome mediante CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- Precarga de fuentes para reducir el tiempo de carga de la tipografía. -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Importa la fuente Zen Antique usada por la interfaz. -->
    <link href="https://fonts.googleapis.com/css2?family=Zen+Antique&display=swap" rel="stylesheet">
    
    <!-- Carga de Sweetalert2 para alertas por medio de CDN-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Carga de TailwindCSS para unidades de estilo por medio de CDN -->
    <script src="https://cdn.tailwindcss.com"></script> 
</head>
<body>
    <!-- HEADER -->
    <header class="main-header">
    <!-- Barra de navegación -->
    <nav class="nav-filters">
        <!-- Logo imagen y su titulo -->
        <div class="logo">
            <img class="logo_img" src="./assets/img/Logo.png" alt="Logo">
            <h1>REELBOX</h1>
        </div>

        <!-- Botones de filtrado -->
        <button class="filter-btn active">Todos</button> <!-- Boton "Todos" activado por defecto -->
        <button class="filter-btn">Vistos</button>
        <button class="filter-btn">Pendientes</button>
    </nav>
</header>
    <main id="contenido_principal">
        <div class="lista_contenido">
            <!-- CATALOGO -->
            <div class="movie-list">
                <!-- Agregar pelicula  -->
                <div class="movie">
                    <!-- Activador del modal para dar de alta una pelicula -->
                    <div onclick="showAddForm()" style="cursor: pointer;">
                         <!--Agregar pelicula IMG  -->
                        <div class="top-button">
                            <div class="movie-poster">
                                <img src="assets/img/icon_añadir_1.png" alt="Agregar Título" class="agregar">
                            </div>
                        </div>
                        <!-- Reutilización de clases para mantener consistencia de estilo -->
                        <div class="movie-info">
                            <!-- Instrucciones -->
                            <h3 class="movie-title">Agregar</h3> 
                            <p class="movie-synopsis">Haz clic para agregar título</p> 
                        </div>
                    </div>
                </div>

                <!-- Recorre cada fila del resultado y genera dinámicamente una tarjeta por película. -->
                <!--Iteración sobre el resultado de la consulta mediante la API OPP de MYSQLi -->
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <!--data-id guarda el id de cada pelicula  -->
                    <div class="caja_contenido" data-id="<?php echo $row['id_peli']; ?>">
                        <!-- Cada tarjeta cuenta con sus propios botones de acción (visto/eliminar) -->
                        <div class="movie-actions">
                            <!-- Checkbox Visto -->
                            <label class="flex items-center space-x-1 bg-gray-700 p-1 rounded-md text-white text-sm cursor-pointer">
                                <!-- Onchange como controlador de eventos (check) 
                                     Llama la función handleVisto en visto.js
                                     Envia 2 parametros: id de la pelicula y el estado del "visto" 
                                     Esto pasa cada vez que se marca o desmarca el checkbox
                                -->
                                <input type="checkbox" data-peli-id="<?php echo $row['id_peli']; ?>" class="casilla" 
                                onchange="handleVisto(<?php echo $row['id_peli']; ?>, this.checked)">
                                <!-- Span esta dentro del label y puede activar el checbox -->
                                <span>Visto</span> 
                            </label>

                            <!--Llama a handleDelete() en main.js pasando el evento, el ID
                                y el nombre de la película (escapado con htmlspecialchars). 
                                Esto evita que se rompa el atributo HTML y protege contra ataques XSS-->
                            <button onclick="handleDelete(event, <?php echo $row['id_peli']; 
                            ?>, '<?php echo htmlspecialchars($row['nombre_peli'], ENT_QUOTES); ?>')" 
                                class="bg-red-600 hover:bg-red-700 text-white p-2 rounded-full transition duration-150 shadow-md">
                                <!-- Icono de bote de basura de FontAwesome -->
                                <i class="fas fa-trash"></i> 
                            </button>
                        </div>

                        <!-- Contenedor de visualización de tarjeta -->
                        <!-- Tarjeta de película: maneja la visualización y el evento para ver detalles -->
                        <div class="movie" onclick="handleViewDetails(
                            <?php echo $row['id_peli']; ?>, 
                            '<?php echo htmlspecialchars($row['nombre_peli'], ENT_QUOTES); ?>', 
                            '<?php echo htmlspecialchars($row['sinopsis_peli'], ENT_QUOTES); ?>',
                            '<?php echo htmlspecialchars($row['imagen_url_peli'] ?: 'https://placehold.co/248x348/2563eb/ffffff?text=Sin+IMG+en+BD', ENT_QUOTES); ?>'
                        )">
                            <!-- Fallback de imagen: 1. BD -> 2. Placeholder azul (si es nulo) -> 3. Placeholder gris (si falla el enlace) -->
                            <img src="<?php echo htmlspecialchars($row['imagen_url_peli'] ?: 'https://placehold.co/248x348/2563eb/ffffff?text=IMG+Nula'); ?>" 
                                alt="Póster de <?php echo htmlspecialchars($row['nombre_peli']); ?>" 
                                class="movie-poster" 
                                onerror="this.onerror=null; this.src='https://placehold.co/248x348/4b5563/ffffff?text=Error+en+IMG';">
                            
                            <!--Info de la peliucla: titulo y sinopsis  -->
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

<!-- Rutas de scripts y ejecución en segundo plano, despues del HTML  -->
<script src="assets/js/visto.js" defer></script>
<script src="assets/js/main.js" defer></script>
</body>
</html>