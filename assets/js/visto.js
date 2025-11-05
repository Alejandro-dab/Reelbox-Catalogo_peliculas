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