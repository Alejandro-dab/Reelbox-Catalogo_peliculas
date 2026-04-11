/**
 * Guarda el estado 'Visto' en localStorage.
 * Esta función se define globalmente para que 'onchange' pueda encontrarla.
 */
function handleVisto(id_peli, isChecked) {
    const key = `visto-${id_peli}`;
    localStorage.setItem(key, isChecked ? 'true' : 'false');
}

/**
 * Carga el estado 'Visto' de localStorage.
 * Esta función es llamada directamente al final del script.
 */
function checkVistoStatus() {
    document.querySelectorAll(".casilla").forEach(function (checkbox) {
        var peliId = checkbox.dataset.peliId;
        var checkboxState = localStorage.getItem(`visto-${peliId}`);

        // Asignación booleana directa (más limpio)
        checkbox.checked = (checkboxState === "true");
    });
}

// 1. Exportar la función 'handleVisto' para que sea accesible desde el HTML (onchange)
window.handleVisto = handleVisto;

// 2. CORRECCIÓN: Ejecutar la revisión directamente.
// El atributo 'defer' en index.php se asegura de que esto se ejecute
// DESPUÉS de que el DOM esté 100% cargado.
checkVistoStatus();

// 1. Seleccionamos los nuevos botones por su clase específica
const filterButtons = document.querySelectorAll('.filter-btn');
// 2. Seleccionamos tus tarjetas (asegúrate de que tus portadas tengan la clase .movie-card)
const movieCards = document.querySelectorAll('.movie-card'); 

filterButtons.forEach(button => {
  button.addEventListener('click', () => {
    // Manejo visual de los botones (el que clickeas se pone blanco/rojo)
    filterButtons.forEach(btn => btn.classList.remove('active'));
    button.classList.add('active');

    // Obtenemos el texto del botón en minúsculas para comparar
    // O mejor aún, si le pones un id o data-attribute:
    const filterValue = button.textContent.toLowerCase().trim();

    movieCards.forEach(card => {
      // Lógica de filtrado
      const isVisto = card.classList.contains('visto'); 

      if (filterValue === 'todos') {
        card.style.display = 'block'; // O 'flex' según tu diseño
      } else if (filterValue === 'vistos' && isVisto) {
        card.style.display = 'block';
      } else if (filterValue === 'pendientes' && !isVisto) {
        card.style.display = 'block';
      } else {
        card.style.display = 'none'; // Aquí es donde se ocultan
      }
    });
  });
});