<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Habitaciones - Hotel Parador</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }

    .navbar {
      background-color: #000;
    }

    .card {
      border: none;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      transition: transform 0.2s;
    }

    .card:hover {
      transform: scale(1.01);
    }

    .card-title {
      font-weight: bold;
    }

    .btn-dark {
      border-radius: 0;
    }

    h2 {
      margin-top: 100px;
      font-weight: 700;
    }

    .carousel-inner img {
      height: 300px;
      object-fit: cover;
    }

    @media (max-width: 768px) {
      .carousel-inner img {
        height: 200px;
      }
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center gap-2" href="#">
      <img src="images/logo.png" alt="Logo" style="width: 60px;">
      <span class="fw-bold">Hotel Parador</span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
        <li class="nav-item"><a class="nav-link active" href="habitaciones.php">Habitaciones</a></li>
        <?php if (isset($_SESSION['rol'])): ?>
        <li class="nav-item"><a class="nav-link" href="reservas_user.php">Mis Reservas</a></li>
        <?php endif; ?>
      </ul>
      <ul class="navbar-nav ms-auto">
        <?php if (isset($_SESSION['correo'])): ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
              <i class="bi bi-person-circle me-1"></i> <?= $_SESSION['correo'] ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <?php if ($_SESSION['rol'] === 'admin'): ?>
                <li><a class="dropdown-item" href="panel_adm.php">Gestionar</a></li>
                <li><a class="dropdown-item" href="paginauser.php">Ver Habitaciones</a></li>
                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalCrearCuenta">Crear Cuenta</a></li>
                <li><hr class="dropdown-divider"></li>
              <?php endif; ?>
              <li><a class="dropdown-item text-danger" href="exit.php">Cerrar Sesión</a></li>
            </ul>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <button class="btn btn-outline-light ms-3" data-bs-toggle="modal" data-bs-target="#modalLogin">Iniciar Sesión</button>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<!-- Habitaciones -->
<div class="container mt-5 pt-5">
  <h2 class="text-center">Nuestras Habitaciones</h2>
  <div class="row mt-4" id="seccionHabitaciones"></div>
</div>
<!-- log -->
<div class="modal fade" id="modalLogin" tabindex="-1" aria-labelledby="modalLoginLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-0">
        <div class="modal-header bg-dark text-white">
          <h5 class="modal-title">Iniciar Sesion</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <form id="formLogin">
            <div class="mb-3">
              <label class="form-label">Correo electronico</label>
              <input type="email" name="correo" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Contrasena</label>
              <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-dark w-100">Ingresar</button>
            <div id="respuesta" class="mt-3 text-danger fw-bold text-center"></div>
          </form>
        </div>
      </div>
    </div>
  </div>
<!-- Modal de reserva -->
<div class="modal fade" id="modalReserva" tabindex="-1" aria-labelledby="modalReservaLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formReserva" method="post">
        <div class="modal-header">
          <h5 class="modal-title">Reservar Habitación</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="habitacionSeleccionada" name="habitacion_id" required>
          <div class="mb-3">
            <label class="form-label">Fecha de Inicio</label>
            <input type="date" class="form-control" name="fecha_ingreso" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Fecha de Fin</label>
            <input type="date" class="form-control" name="fecha_salida" required>
          </div>
          <div id="respuestaReserva" class="text-center mt-2 fw-bold"></div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-dark">Crear Reserva</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
  fetch("Rhabitaciones.php")
    .then(res => res.json())
    .then(json => {
      if (json.data) mostrarHabitacionesPublicas(Object.values(json.data));
    });

  const form = document.getElementById("formReserva");
  const respuesta = document.getElementById("respuestaReserva");

  form.addEventListener("submit", async (e) => {
    e.preventDefault();
    const datos = new FormData(form);
    const res = await fetch("createreservas.php", {
      method: "POST",
      body: datos
    });
    const json = await res.json();

    respuesta.textContent = json.mensaje;
    respuesta.className = json.status === "ok" ? "text-success mt-2" : "text-danger mt-2";

    if (json.status === "ok") {
      setTimeout(() => {
        bootstrap.Modal.getInstance(document.getElementById("modalReserva")).hide();
        form.reset();
        respuesta.textContent = "";
      }, 2000);
    }
  });
});

function mostrarHabitacionesPublicas(habitaciones) {
  const seccion = document.getElementById("seccionHabitaciones");
  let html = "";

  habitaciones.forEach((hab) => {
    const idCarousel = `carousel${hab.id}`;
    let carousel = `
      <div id="${idCarousel}" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">`;

    hab.fotos.forEach((foto, i) => {
      carousel += `
        <div class="carousel-item ${i === 0 ? 'active' : ''}">
          <img src="${foto}" class="d-block w-100">
        </div>`;
    });

    carousel += `
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#${idCarousel}" data-bs-slide="prev">
          <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#${idCarousel}" data-bs-slide="next">
          <span class="carousel-control-next-icon"></span>
        </button>
      </div>`;

    html += `
      <div class="col-md-6 mb-4">
        <div class="card">
          ${carousel}
          <div class="card-body">
            <h5 class="card-title">${hab.tipo}</h5>
            <p class="card-text">Nro: ${hab.numero} | Piso: ${hab.piso}</p>
            <p class="card-text">Superficie: ${hab.superficie} m² | Camas: ${hab.numero_camas}</p>
            <button class="btn btn-dark" onclick="mostrarReserva(${hab.id})">Reservar</button>
          </div>
        </div>
      </div>`;
  });

  seccion.innerHTML = html;
}

function mostrarReserva(habitacionId) {
  document.getElementById("habitacionSeleccionada").value = habitacionId;
  const modal = new bootstrap.Modal(document.getElementById("modalReserva"));
  modal.show();
}
</script>
<script src="script.js"></script>
</body>
</html>
