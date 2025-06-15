<?php
session_start();
require("conexion.php");
require("verificarsesion.php");

$id_correo = $_SESSION['id'];
if (!isset($_GET['id'])) {
    header("Location: bandeja.php");
    exit;
}

$correo_id = $_GET['id'];

$stmt = $con->prepare('SELECT id FROM correos WHERE id = ? AND (remitente_id = ? OR destinatario_id = ?)');
$stmt->bind_param("iii", $correo_id, $id_correo, $id_correo);
$stmt->execute();
$result = $stmt->get_result();


$stmt_del = $con->prepare("DELETE FROM correos WHERE id = ?");
$stmt_del->bind_param("i", $correo_id);
$stmt_del->execute();

header("Location: bandeja.php");
exit;
?>
