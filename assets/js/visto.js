function showDialog(title, synopsis, element) {
  const dialog = document.createElement('div');
  dialog.classList.add('dialog-overlay');

  const dialogContent = document.createElement('div');
  dialogContent.classList.add('dialog-content');

  const titleLabel = document.createElement('h2');
  titleLabel.textContent = title;

  const synopsisLabel = document.createElement('p');
  synopsisLabel.textContent = synopsis;

  const seenButton = document.createElement('button');
  seenButton.textContent = 'Vistos';
  seenButton.addEventListener('click', () => {
    alert('Contenido agregado a "Vistos"');
    dialog.remove();
  });

  const pendingButton = document.createElement('button');
  pendingButton.textContent = 'Pendientes';
  pendingButton.addEventListener('click', () => {
    alert('Contenido agregado a "Pendientes"');
    dialog.remove();
  });

  dialogContent.appendChild(titleLabel);
  dialogContent.appendChild(synopsisLabel);
  dialogContent.appendChild(seenButton);
  dialogContent.appendChild(pendingButton);

  dialog.appendChild(dialogContent);
  document.body.appendChild(dialog);

  dialog.addEventListener('click', (event) => {
    if (event.target === dialog) {
      dialog.remove();
    }
  });
}


function addToWatched(title, synopsis) {
  const watchedMovies = JSON.parse(localStorage.getItem('watchedMovies')) || [];
  const movie = { title, synopsis };
  watchedMovies.push(movie);
  localStorage.setItem('watchedMovies', JSON.stringify(watchedMovies));
}


function addToPending(title, synopsis) {
  const pendingMovies = JSON.parse(localStorage.getItem('pendingMovies')) || [];
  const movie = { title, synopsis };
  pendingMovies.push(movie);
  localStorage.setItem('pendingMovies', JSON.stringify(pendingMovies));
}


document.addEventListener('DOMContentLoaded', () => {
  displayWatchedMovies();
  displayPendingMovies();
});

function displayWatchedMovies() {
  const vistosContainer = document.getElementById('vistos');
  const vistosMovies = JSON.parse(localStorage.getItem('vistos')) || [];

  if (vistosMovies.length === 0) {
    vistosContainer.innerHTML = '<p>No hay películas vistas.</p>';
  } else {
    vistosContainer.innerHTML = '';

    vistosMovies.forEach((movie) => {
      const movieElement = createMovieElement(movie.title, movie.synopsis);
      vistosContainer.appendChild(movieElement);
    });
  }
}

function displayPendingMovies() {
  const pendientesContainer = document.getElementById('pendientes');
  const pendientesMovies = JSON.parse(localStorage.getItem('pendientes')) || [];

  if (pendientesMovies.length === 0) {
    pendientesContainer.innerHTML = '<p>No hay películas pendientes.</p>';
  } else {
    pendientesContainer.innerHTML = '';

    pendientesMovies.forEach((movie) => {
      const movieElement = createMovieElement(movie.title, movie.synopsis);
      pendientesContainer.appendChild(movieElement);
    });
  }
}

function createMovieElement(title, synopsis) {
  const movieElement = document.createElement('div');
  movieElement.classList.add('movie');

  const titleLabel = document.createElement('h3');
  titleLabel.textContent = title;

  const synopsisLabel = document.createElement('p');
  synopsisLabel.textContent = synopsis;

  movieElement.appendChild(titleLabel);
  movieElement.appendChild(synopsisLabel);

  return movieElement;
}

function toggleForm() {
  const loginForm = document.getElementById('login-form');
  const registerForm = document.getElementById('register-form');
  const formTitle = document.getElementById('form-title');
  
  if (loginForm.classList.contains('active')) {
    loginForm.classList.remove('active');
    registerForm.classList.add('active');
    formTitle.textContent = 'Registro';
  } else {
    loginForm.classList.add('active');
    registerForm.classList.remove('active');
    formTitle.textContent = 'Inicio de Sesión';
  }
}


// Obtener el elemento del checkbox
var miCasilla = document.getElementById("Casilla");

// Verificar si hay un estado guardado en la cookie
var miCasillaState = getCookie("CasillaState");

// Restaurar el estado del checkbox
if (miCasillaState && miCasillaState === "checked") {
  miCasilla.checked = true;
}

// Escuchar el evento de cambio del checkbox
miCasilla.addEventListener("change", function () {
  // Guardar el estado actual en la cookie
  if (miCasilla.checked) {
    setCookie("CasillaState", "checked", 365); // La cookie expirará en 365 días
  } else {
    deleteCookie("CasillaState");
  }
});

// Función para obtener el valor de una cookie
function getCookie(name) {
  var cookieName = name + "=";
  var decodedCookie = decodeURIComponent(document.cookie);
  var cookieArray = decodedCookie.split(";");

  for (var i = 0; i < cookieArray.length; i++) {
    var cookie = cookieArray[i];
    while (cookie.charAt(0) === " ") {
      cookie = cookie.substring(1);
    }
    if (cookie.indexOf(cookieName) === 0) {
      return cookie.substring(cookieName.length, cookie.length);
    }
  }
  return "";
}

// Función para establecer una cookie
function setCookie(name, value, days) {
  var expires = "";
  if (days) {
    var date = new Date();
    date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
    expires = "; expires=" + date.toUTCString();
  }
  document.cookie = name + "=" + value + expires + "; path=/";
}

// Función para eliminar una cookie
function deleteCookie(name) {
  document.cookie = name + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
}





