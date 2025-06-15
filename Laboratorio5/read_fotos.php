<?php
include("conexion.php");

header("Content-Type: application/json");

if (!isset($_GET['habitacion_id'])) {
    echo json_encode(["status" => "error", "mensaje" => "Falta el ID de la habitación"]);
    exit;
}

$id = intval($_GET['habitacion_id']);

$sql = $con->prepare("SELECT fotografia FROM fotografias_habitacion WHERE habitacion_id = ? ORDER BY orden");
$sql->bind_param("i", $id);
$sql->execute();
$res = $sql->get_result();

$fotos = [];

while ($row = $res->fetch_assoc()) {
    $fotos[] = "images/" . $row['fotografia'];
}

echo json_encode(["status" => "ok", "fotos" => $fotos]);
