<?php
session_start();
include("conexion.php");
require("verificarsesion.php");
require("verificarnivel.php");

$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$password = $_POST['password']; 
$nivel = $_POST['nivel'];
$id = $_POST['id'];
//para la pass
if (!empty($password)) {
    $passwordsha = sha1($password);
    $stmt = $con->prepare("UPDATE usuarios SET nombre=?, correo=?, password=?, nivel=? WHERE id=?");
    $stmt->bind_param("sssii", $nombre, $correo, $passwordsha, $nivel, $id);
} else {
    $stmt = $con->prepare("UPDATE usuarios SET nombre=?, correo=?, nivel=? WHERE id=?");
    $stmt->bind_param("ssii", $nombre, $correo, $nivel, $id);
}

if ($stmt->execute()) {
    echo "Usuario actualizado correctamente.";
} else {
    echo "Error al actualizar: " . $stmt->error;
}

$stmt->close();
$con->close();
?>
<meta http-equiv="refresh" content="3;url=read.php">
