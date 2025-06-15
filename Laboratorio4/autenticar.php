<?php 
session_start();
include("conexion.php");

$correo = $_POST['correo'];
$password = sha1($_POST['password']);

$stmt = $con->prepare('SELECT id, correo, nombre, nivel, Estado FROM usuarios WHERE correo=? AND password=?');
$stmt->bind_param("ss", $correo, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();
    if ((int)$usuario['Estado'] == 1) {
        echo "Tu cuenta está inhabilitada. Contacta con el administrador.";
        echo '<meta http-equiv="refresh" content="3;url=formlogin.html">';
        exit();
    }
    $_SESSION['id'] = $usuario['id'];
    $_SESSION['correo'] = $correo;
    $_SESSION['nivel'] = $usuario['nivel'];
    $_SESSION['nombre'] = $usuario['nombre'];

    if ($usuario['nivel'] == 1) {
        header("Location: read.php");
    } else {
        header("Location: bandeja.php");
    }
    exit();
} else {
    echo "Error: datos de autenticación incorrectos.";
    echo '<meta http-equiv="refresh" content="3;url=formlogin.html">';
    exit();
}
?>
