<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Panel Admin</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
</head>

<body>

  <?php
  session_start();
  include("verificarsesion.php");
  include("conexion.php");

  ?>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark w-100">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center gap-2" href="#">
        <img src="images/logo.png" alt="Logo" style="width: 60px;">
        <span class="fw-bold">Hotel Parador</span>
      </a>
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link text-white" href="index.php" id="btnInicio">Inicio</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="#" id="btnUsers">Usuarios</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="#" id="btnReservas">Reservas</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="#" id="btnHabitaciones">Habitaciones</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="#" id="btnFotografias">Fotografias</a></li>
      </ul>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white d-flex align-items-center" href="#" role="button"
              data-bs-toggle="dropdown">
              <i class="bi bi-person-circle me-1"></i> <?= $_SESSION['correo'] ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">

              <li><a class="dropdown-item" href="panel_adm.php">Gestionar</a></li>
              <li><a class="dropdown-item" href="paginauser.php">Ver Habitaciones</a></li>
              <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalCrearCuenta">Crear
                  Cuenta</a></li>
              <li>

                <hr class="dropdown-divider">
              </li>

              <li><a class="dropdown-item" href="editar-perfil.php">Editar Perfil</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>

              <li><a class="dropdown-item text-danger" href="exit.php">Cerrar Sesión</a></li>
            </ul>
          </li>

        </ul>
      </div>
    </div>
  </nav>
  <!-- Modal Crear Cuenta -->
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
            <div class="mb-3">
              <label class="form-label">Rol</label>
              <select name="rol" class="form-select">
                <option value="cliente">Cliente</option>
                <option value="admin">Administrador</option>
              </select>
            </div>
            <button type="submit" class="btn btn-dark w-100">Registrarse</button>
            <div id="respuestaRegistro" class="mt-3 text-danger fw-bold text-center"></div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Editar Usuario -->
  <div class="modal fade" id="modalEditarUsuario" tabindex="-1" aria-labelledby="modalLoginLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-0">
        <form id="formEditarUsuario">
          <div class="modal-header bg-dark text-white">
            <h5 class="modal-title">Editar Usuario</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="id" id="editarId">

            <div class="mb-3">
              <label for="editarCorreo" class="form-label">Correo</label>
              <input type="email" class="form-control" name="correo" id="editarCorreo" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Rol</label>
              <div class="dropdown w-100">
                <button class="btn btn-secondary dropdown-toggle w-100" type="button" id="dropdownRolBtn"
                  data-bs-toggle="dropdown" aria-expanded="false">Seleccionar rol</button>
                <ul class="dropdown-menu w-100" aria-labelledby="dropdownRolBtn">
                  <li><a class="dropdown-item rol-opcion" href="#" data-valor="admin">Admin</a></li>
                  <li><a class="dropdown-item rol-opcion" href="#" data-valor="cliente">Cliente</a></li>
                </ul>
              </div>
              <input type="hidden" name="rol" id="editarRol">
            </div>

            <div class="mb-3">
              <label for="editarPassword" class="form-label">Nueva Contraseña (opcional)</label>
              <input type="password" class="form-control" name="password" id="editarPassword">
            </div>
          </div>

          <div class="modal-footer">
            <button type="submit" class="btn btn-dark w-100">Guardar Cambios</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="container my-4">
    <div id="contenedor">
      <h1 class="text-center mb-4">Bienvenido <?php echo ($_SESSION['correo']); ?></h1>

    </div>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="script.js"></script>

</body>

</html>