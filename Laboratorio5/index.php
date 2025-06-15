<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Hotel Parador</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <style>
    .dropdown-menu .dropdown-item:focus,
    .dropdown-menu .dropdown-item:active {
      background-color: transparent;
      color: inherit;
      outline: none;
      box-shadow: none;
    }

    .nav-item :hover {
      background-color: rgba(23, 23, 23, 0.46);
      */ border-radius: 1px;
    }

    header.hero {

      background-size: cover;
      height: 100vh;
      color: white;
      position: relative;
    }

    header.hero::before {
      content: '';
      position: absolute;
      inset: 0;
      background: rgba(0, 0, 0, 0.5);
    }

    .hero-content {
      position: relative;
      z-index: 1;
    }

    .navbar-nav .nav-link {
      font-weight: 500;
      margin-right: 15px;
    }

    .navbar-nav .nav-item:last-child .nav-link {
      margin-right: 0;

    }
  </style>
</head>

<body>
  <?php session_start(); ?>

  <nav class="navbar navbar-expand-lg navbar-dark bg-transparent position-absolute w-100 z-2">
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
          <li class="nav-item"><a class="nav-link text-white" href="index.php">Inicio</a></li>
          <li class="nav-item"><a class="nav-link text-white" href="habitaciones.php">Habitaciones</a></li>
          <?php if (isset($_SESSION['rol'])): ?>
          <li class="nav-item"><a class="nav-link text-white" href="#"> Mis Reservas</a></li>
           <li class="nav-item"><a class="nav-link text-white" href="paginaCliente.php"> Mas informacion para las habitaciones</a></li>
          <?php endif; ?>
        </ul>

        <ul class="navbar-nav ms-auto">
          <?php if (isset($_SESSION['correo'])): ?>
            <li class="nav-item2 dropdown">
              <a class="nav-link dropdown-toggle text-white d-flex align-items-center" href="#" role="button"
                data-bs-toggle="dropdown">
                <i class="bi bi-person-circle me-1"></i> <?= $_SESSION['correo'] ?></a>
              <ul class="dropdown-menu dropdown-menu-end ">
                <?php if ($_SESSION['rol'] === 'admin'): ?>
                  <li><a class="dropdown-item" href="panel_adm.php">Gestionar</a></li>
                  <li><a class="dropdown-item" href="paginauser.php">Ver Habitaciones</a></li>
                  <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalCrearCuenta">Crear Cuenta</a></li>
                  <li>
                    <hr class="dropdown-divider">
                  </li>
                <?php elseif ($_SESSION['rol'] === 'cliente'): ?>
                  <li><a class="dropdown-item" href="editar-perfil.php">Editar Perfil</a></li>
                  <li>
                    <hr class="dropdown-divider">
                  </li>
                <?php endif; ?>
                <li><a class="dropdown-item text-danger" href="exit.php">Cerrar Sesión</a></li>
              </ul>
            </li>
          <?php else: ?>
            <li class="nav-item" id="loginBtn">
              <button class="btn btn-outline-light ms-3" data-bs-toggle="modal" data-bs-target="#modalLogin">Iniciar
                Sesión</button>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>
  <!-- caru -->
  <header class="hero position-relative">
    <div id="carouselHero" class="carousel slide carousel-fade position-absolute w-100 h-100" data-bs-ride="carousel">
      <div class="carousel-inner h-100">
        <div class="carousel-item active h-100">
          <img src="images/foto1.avif" class="d-block w-100 h-100 object-fit-cover" alt="...">
        </div>
        <div class="carousel-item h-100">
          <img src="images/foto2.avif" class="d-block w-100 h-100 object-fit-cover" alt="...">
        </div>
        <div class="carousel-item h-100">
          <img src="images/foto3.avif" class="d-block w-100 h-100 object-fit-cover" alt="...">
        </div>
      </div>
    </div>
    <!-- abajo -->
    <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50"></div>
    <div
      class="hero-content position-relative text-white d-flex flex-column justify-content-center align-items-center text-center"
      style="height: 100vh;">
      <h1 class="display-4 fw-bold">Bienvenido al Parador</h1>
      <a href="formreservar.php" class="btn btn-outline-light btn-lg mt-3">Reservar Ahora</a>
    </div>
    <div class="position-absolute bottom-0 start-0 w-100 text-center text-white p-3">
      <p class="mb-0">Hotel Parador - Tu hogar lejos de casa</p>
    </div>
  </header>

  <section class="container my-5">
    <div class="row align-items-center">
      <div class="col-md-6 mb-4 mb-md-0">
        <div id="habitacionCarousel" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-inner rounded shadow">
            <div class="carousel-item active">
              <img src="images/foto5.avif" alt="Suite 1" class="d-block w-100 img-fluid">
            </div>
            <div class="carousel-item">
              <img src="images/foto4.avif" alt="Suite 2" class="d-block w-100 img-fluid">
            </div>
            <div class="carousel-item">
              <img src="images/foto3.avif" alt="Suite 3" class="d-block w-100 img-fluid">
            </div>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#habitacionCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
            <span class="visually-hidden">Anterior</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#habitacionCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
            <span class="visually-hidden">Siguiente</span>
          </button>
        </div>
      </div>
      <div class="col-md-6">
        <h3 class="text-uppercase fw-bold text-secondary">Suites & Habitaciones</h3>
        <p class="text-muted">
          Nuestras 39 habitaciones tienen todo lo que necesitas<br>
          para una estadía placentera y experiencias con detalles coloniales.
        </p>
        <a href="#" class="btn btn-outline-dark mt-2">Ver más</a>
      </div>
    </div>
  </section>


  <!-- logeo -->
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
  <!-- crear cuenta modal -->
  <div class="modal fade" id="modalCrearCuenta" tabindex="-1" aria-labelledby="modalCrearCuentaLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-0">
        <div class="modal-header bg-dark text-white">
          <h5 class="modal-title">Crear Cuenta</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <form id="formCrearCuenta">
            <div class="mb-3">
              <label class="form-label">Correo</label>
              <input type="email" name="correo" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Contrasena</label>
              <input type="password" name="password" class="form-control" required>
            </div>
            <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
              <div class="mb-3">
                <label class="form-label">Rol</label>
                <select name="rol" class="form-select">
                  <option value="cliente">Cliente</option>
                  <option value="admin">Administrador</option>
                </select>
              </div>
            <?php endif; ?>
            <button type="submit" class="btn btn-dark w-100">Registrarse</button>
            <div id="respuestaRegistro" class="mt-3 text-danger fw-bold text-center"></div>
          </form>
        </div>
      </div>
    </div>
  </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>

</html>