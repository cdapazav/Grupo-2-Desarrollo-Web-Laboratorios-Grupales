<?php
session_start();
include("conexion.php");
require("verificarsesion.php");
require("verificarnivel.php");

if (isset($_POST['nombre'], $_POST['correo'], $_POST['password'], $_POST['nivel'])) {
    $nombres = $_POST['nombre'];
    $correo = $_POST['correo'];
    $password = sha1($_POST['password']);  
    $nivel = $_POST['nivel'];    
    $estado = 0;

    $stmt = $con->prepare('INSERT INTO usuarios (nombre, correo, password, nivel, Estado) VALUES (?, ?, ?, ?, ?)');

    $stmt->bind_param("sssii", $nombres, $correo, $password, $nivel, $estado);

    if ($stmt->execute()) {
        echo "Nuevo usuario creado con éxito";
    } else {
        echo "Error al crear usuario: " . $stmt->error;
    }

    $stmt->close();
    $con->close();

} else {
    echo "Error: Faltan datos requeridos.";
}

?>

<meta http-equiv="refresh" content="3;url=read.php">
