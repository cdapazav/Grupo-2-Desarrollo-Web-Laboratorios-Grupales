<?php
session_start();
include("conexion.php");
require("verificarsesion.php");
require("verificarnivel.php");

if (isset($_GET['id']) && isset($_GET['estado'])) {
    $id = $_GET['id'];
    $nuevoEstado = $_GET['estado']; //para obtener el estado en el que se encuetra ese user

    $stmt = $con->prepare('UPDATE usuarios SET Estado=? WHERE id=?');
    $stmt->bind_param("ii", $nuevoEstado, $id);

    if ($stmt->execute()) {
        echo "Estado del usuario actualizado con éxito.";
        echo '<meta http-equiv="refresh" content="1;url=read.php">';
    } else {
        echo "Error al actualizar el estado del usuario: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Error: datos incompletos.";
}
