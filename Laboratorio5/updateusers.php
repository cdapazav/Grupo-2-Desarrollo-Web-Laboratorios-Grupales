<?php
session_start();
include("conexion.php");
include("verificarsesion.php");

header('Content-Type: application/json');

// Recibir los datos
$id = $_POST['id'];
$correo = $_POST['correo'];
$rol = $_POST['rol'];
$password = isset($_POST['password']) ? $_POST['password'] : "";

// Validar datos básicos obligatorios
if ($id === "" || $correo === "" || $rol === "") {
    echo json_encode([
        "status" => "error",
        "message" => "Faltan datos obligatorios."
    ]);
    exit;
}

// Si se proporciona una nueva contraseña, se actualiza también
if ($password !== "") {
    $password_sha1 = sha1($password);
    $stmt = $con->prepare("UPDATE usuarios SET correo = ?, rol = ?, password = ? WHERE id = ?");
    $stmt->bind_param("sssi", $correo, $rol, $password_sha1, $id);
} else {
    $stmt = $con->prepare("UPDATE usuarios SET correo = ?, rol = ? WHERE id = ?");
    $stmt->bind_param("ssi", $correo, $rol, $id);
}

// Ejecutar y responder
if ($stmt->execute()) {
    echo json_encode([
        "status" => "success",
        "message" => "Usuario actualizado correctamente."
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Error al actualizar el usuario: " . $stmt->error
    ]);
}

$con->close();
?>
