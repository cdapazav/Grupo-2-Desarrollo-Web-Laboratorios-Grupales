<?php
session_start();
include("conexion.php");
require("verificarsesion.php");
require("verificarnivel.php"); 

$asunto = $_POST['asunto'];
$mensaje = $_POST['mensaje'];
$remitente_id = $_SESSION['id']; 


$sql = "SELECT id FROM usuarios WHERE nivel = 0 AND Estado = 0";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    $stmt = $con->prepare("INSERT INTO correos (remitente_id, destinatario_id, asunto, mensaje) VALUES (?, ?, ?, ?)");

    while ($row = $result->fetch_assoc()) {
        $destinatario_id = $row['id'];
        $stmt->bind_param("iiss", $remitente_id, $destinatario_id, $asunto, $mensaje);
        $stmt->execute();
    }

    echo "Aviso enviado a todos los usuarios estándar activos.";
} else {
    echo "No hay usuarios estándar activos a quienes enviar el aviso.";
}

$con->close();
?>
<meta http-equiv="refresh" content="3;url=read.php">
