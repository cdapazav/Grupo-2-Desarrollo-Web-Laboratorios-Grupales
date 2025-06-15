<?php session_start();
include("conexion.php");
include("verificarsesion.php");

header('Content-Type: application/json');

$id=$_GET['id'];

$stmt = $con->prepare("DELETE FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    $response = [
        "status" => "success",
        "message" => "Usuario eliminado correctamente."
    ];
} else {
    $response = [
        "status" => "error",
        "message" => "Error al eliminar el usuario: " . $stmt->error
    ];
}
$con->close();
?>