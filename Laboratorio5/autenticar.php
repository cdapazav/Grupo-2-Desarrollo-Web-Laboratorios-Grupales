<?php
session_start();
include("conexion.php");

header('Content-Type: application/json');

$correo = $_POST['correo'] ?? '';
$password = sha1($_POST['password'] ?? '');


$stmt = $con->prepare("SELECT id, correo, rol FROM usuarios WHERE correo = ? AND password = ?");
$stmt->bind_param("ss", $correo, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();


    $_SESSION['id'] = $usuario['id'];
    $_SESSION['correo'] = $usuario['correo'];
    $_SESSION['rol'] = $usuario['rol'];


    echo json_encode([
        "status" => $usuario['rol'], 
        "correo" => $usuario['correo']
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "mensaje" => '<strong class="text-body-secondary">Datos incorrectos</strong> <a href="#" id="enlaceCrearCuenta" class="text-dark">Crear cuenta</a>'
    ]);
}
?>

