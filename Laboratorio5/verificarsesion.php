<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION["id"])) {
    echo "Acceso no autorizado. Debe iniciar sesión.";
    exit;
}
?>
