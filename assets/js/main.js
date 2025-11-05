// URL de la API (variable global para este script)
const API_URL = 'api/peliculas.php';

/** Muestra alerta de éxito. */
const showSuccess = (title, text) => {
    Swal.fire({
        icon: 'success', title: title, text: text, showConfirmButton: false, timer: 2500, toast: true, position: 'top-end'
    });
};

/** Envía datos CRUD a la API. */
const crudOperation = async (method, data) => {
    // Muestra una alerta de procesamiento
    Swal.fire({ title: 'Procesando...', text: 'Enviando datos al servidor...', allowOutsideClick: false, didOpen: () => { Swal.showLoading() } });
    
    try {
        const response = await fetch(API_URL, {
            method: method,
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });
        
        const result = await response.json();

        if (response.ok && result.status < 400) {
            showSuccess(method === 'DELETE' ? 'Eliminado' : 'Guardado', result.message || 'Operación realizada con éxito.');
            // Recargar la página para ver el cambio (el método más simple para PHP)
            setTimeout(() => window.location.reload(), 500);
        } else {
            Swal.fire({ icon: 'error', title: 'Error', text: result.message || `Error en ${method}.` });
        }
    } catch (error) {
        Swal.fire({ 
            icon: 'error', 
            title: 'Error de Conexión', 
            text: 'No se pudo conectar con el servidor API. (¿api/conexion.php no tiene un "echo"?)' 
        });
    }
};

/** Muestra el formulario de SweetAlert para Añadir. */
function showAddForm() {
    Swal.fire({
        title: 'Añadir Nueva Película',
        html: `
            <div class="space-y-4 text-left">
                <label class="block text-gray-700 text-sm font-bold pt-2" for="nombre_peli">Título *</label>
                <input id="nombre_peli" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500" type="text" placeholder="Ej: Interstellar" required>
                
                <label class="block text-gray-700 text-sm font-bold pt-2" for="imagen_url_peli">URL de Imagen</label>
                <input id="imagen_url_peli" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500" type="url" placeholder="Ej: https://...">
                
                <label class="block text-gray-700 text-sm font-bold pt-2" for="sinopsis_peli">Sinopsis *</label>
                <textarea id="sinopsis_peli" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Escribe la sinopsis completa aquí..." required></textarea>
            </div>
        `,
        focusConfirm: false,
        showCancelButton: true,
        confirmButtonText: 'Crear Película',
        cancelButtonText: 'Cancelar',
        preConfirm: () => {
            const nombre_peli = Swal.getPopup().querySelector('#nombre_peli').value.trim();
            const imagen_url_peli = Swal.getPopup().querySelector('#imagen_url_peli').value.trim();
            const sinopsis_peli = Swal.getPopup().querySelector('#sinopsis_peli').value.trim();

            if (!nombre_peli || !sinopsis_peli) {
                Swal.showValidationMessage(`El título y la sinopsis son obligatorios.`);
                return false;
            }
            
            crudOperation('POST', { nombre_peli, imagen_url_peli, sinopsis_peli });
        }
    });
}

/** Maneja la acción de eliminar. */
function handleDelete(event, id, nombre) {
    event.stopPropagation(); // Evita que se abra el modal de detalles
    
    Swal.fire({
        title: `¿Eliminar "${nombre}"?`,
        text: "Esta acción eliminará el título de la base de datos.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#4b5563',
        confirmButtonText: 'Sí, Eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            crudOperation('DELETE', { id_peli: id });
        }
    });
}

/** Muestra la sinopsis completa. */
function handleViewDetails(id, nombre, sinopsis, imageUrl) {
    Swal.fire({
        title: nombre,
        html: `
            <div class="flex flex-col md:flex-row items-start space-y-4 md:space-y-0 md:space-x-4 text-left">
                <img src="${imageUrl}" class="w-32 md:w-40 rounded-lg shadow-xl flex-shrink-0" alt="Póster" onerror="this.onerror=null; this.src='https://placehold.co/250x150/4b5563/ffffff?text=No+Image';">
                <div class="flex-grow">
                    <p class="text-sm text-gray-500 mb-2">ID: ${id}</p>
                    <p class="text-gray-600 leading-relaxed">${sinopsis}</p>
                </div>
            </div>
        `,
        confirmButtonText: 'Cerrar',
        customClass: { title: 'text-2xl font-bold text-indigo-600', htmlContainer: 'text-left' },
    });
}

// Exportar funciones para que sean accesibles globalmente desde el HTML (onclick)
// (Esto es necesario porque las cargamos con 'defer')
window.handleDelete = handleDelete;
window.showAddForm = showAddForm;
window.handleViewDetails = handleViewDetails;