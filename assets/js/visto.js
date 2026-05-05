//APLICAR filtro

function aplicarFiltroActivo() {
  const botonActivo = document.querySelector(".filter-btn.active");
  if (!botonActivo) return; // seguridad: si no hay botón activo, salir
  const filtro = botonActivo.textContent.toLowerCase().trim();
  document.querySelectorAll(".caja_contenido").forEach(function (tarjeta) {
    const estaVisto = tarjeta.classList.contains("visto"); // true si la tarjeta tiene la clase "visto"
    if (filtro === "todos") {
      tarjeta.style.display = "";      // "" restaura el display original (no oculta nada)
    } else if (filtro === "vistos") {
      tarjeta.style.display = estaVisto ? "" : "none";  // muestra solo las marcadas
    } else if (filtro === "pendientes") {
      tarjeta.style.display = !estaVisto ? "" : "none"; // muestra solo las NO marcadas
    }
  });
}

/**
 * Guarda el estado 'Visto' en localStorage.
 * Esta función se define globalmente para que 'onchange' pueda encontrarla.
 */
function handleVisto(id_peli, isChecked) {
    const key = `visto-${id_peli}`;
    localStorage.setItem(key, isChecked ? 'true' : 'false');

    const tarjeta = document.querySelector(`.caja_contenido[data-id="${id_peli}"]`);
    if (!tarjeta) return;

    if (isChecked){
      tarjeta.classList.add("visto");    // marcada → tarjeta queda como "vista"
    } else{
      tarjeta.classList.remove("visto"); // desmarcada → vuelve a ser "pendiente"
    }
    // Llama al motor de filtrado para que la tarjeta se muestre/oculte de inmediato si hay un filtro activo distinto a "Todos"
    aplicarFiltroActivo();
}

/**
 * Carga el estado 'Visto' de localStorage.
 * Esta función es llamada directamente al final del script.
 */
function checkVistoStatus(){
  document.querySelectorAll(".caja_contenido").forEach(function (tarjeta){
    const id = tarjeta.dataset.id; 
    const checkbox = tarjeta.querySelector(".casilla");
    if (!checkbox || !id) return;
    const estadoGuardado = localStorage.getItem(`visto-${id}`);
    const estaVisto = estadoGuardado === "true";

    if (estaVisto) {
      tarjeta.classList.add("visto");    // agrega la clase que usan los filtros
    } else{
      tarjeta.classList.remove("visto"); // asegura que no quede la clase por error
    }
  });
}

// Exportar la función 'handleVisto' para que sea accesible desde el HTML (onchange)
window.handleVisto = handleVisto;

// Ejecuta la revisión directamente.
// El atributo 'defer' en index.php se asegura de que esto se ejecute
// DESPUÉS de que el DOM esté 100% cargado.
checkVistoStatus();



// Seleccionamos los nuevos botones por su clase específica
const filterButtons = document.querySelectorAll('.filter-btn');

filterButtons.forEach(button => {
  button.addEventListener('click', () => {
    filterButtons.forEach(btn => btn.classList.remove('active'));
    button.classList.add('active');
    aplicarFiltroActivo();
  });
});