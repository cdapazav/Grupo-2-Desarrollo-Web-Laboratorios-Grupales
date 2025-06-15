<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Reserva Fácil</title>
    <script src="script.js"></script>
    <link rel="stylesheet" href="paginaCliente.css">
</head>

<body>
    <header class="navbar-superior">
        <div class="navbar-logo">
            <img src="images/logo.png" alt="Hotel Logo" class="logo-img">
            <span class="nombre-pagina">Hotel Parador</span>
        </div>
        <div class="navbar-controles" style="display:flex;align-items:center;gap:24px;">
            <button id="btn-ubicacion"
                style="background:none; border:none; cursor:pointer; display:flex; flex-direction:column; align-items:center;">
                <img src="images/icon_ubi.png" alt="Ubicación" style="width:38px; height:38px; display:block;">
                <span
                    style="color:white; font-size:20px; font-weight:600;">Ubicación</span>
            </button>
            <select onchange="cargarImagen(this.value)"
                style="padding:8px 16px; border-radius:10px;  #007bff; color:black; font-size:25; font-weight:600;">
                <option value="" selected>Ver todas las habitaciones</option>
                <option value="Individual">Individual</option>
                <option value="Matrimonial">Matrimonial</option>
                <option value="Familiar">Familiar</option>
                <option value="Gemelas">Gemelas</option>
            </select>
            <button id="btn-ver-reservas"
                style="padding:8px 18px;background:#1976d2;color:#fff;font-size:1rem;font-weight:600;border:none;border-radius:10px;cursor:pointer;transition:background 0.2s;font-size:20px;">Mis
                reservas</button>
        </div>
        <div class="navbar-usuario">
            <img src="images/logo.png" alt="Usuario" class="usuario-img">
            <span class="usuario-nombre">
                <?php
                session_start();
                if (isset($_SESSION['correo'])) {
                    echo htmlspecialchars($_SESSION['correo']);
                } else {
                    echo 'Invitado';
                }
                ?>
            </span>
        </div>
    </header>
    <div class="contenedor" style="margin-left:0;width:100%;">
        <div id="contenido" style="width:100%;"></div>
        <div id="myModal" class="modal" style="display:none;">
            <div class="modal-content">
                <span class="close" id="closeModal">&times;</span>
                <div id="contenido-modal"></div>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            cargarImagen("");
            var btnUbi = document.getElementById('btn-ubicacion');
            if (btnUbi) {
                btnUbi.onclick = function () {
                    var modal = document.getElementById('myModal');
                    var contenidoModal = document.getElementById('contenido-modal');
                    contenidoModal.innerHTML = '<img src="images/map.png" alt="Mapa ubicación" style="width:100%;max-width:500px;display:block;margin:auto;border-radius:12px;"><div style="text-align:center;margin-top:10px;color:#333;font-size:1.1rem;">Av. Ejemplo #123<br>Sucre, Bolivia</div>';
                    modal.style.display = 'block';
                }
            }
            var btnVerReservas = document.getElementById('btn-ver-reservas');
            if (btnVerReservas) {
                btnVerReservas.onclick = function () {
                    cargarContenido('readRerserva.php');
                }
            }
        });
    </script>
</body>

</html>