<?php
session_start();
include("conexion.php");
// include("verificarsesion.php");

header('Content-Type: application/json');

$sql = "SELECT h.id, h.numero, h.piso, th.nombre AS tipo 
        FROM habitaciones h 
        JOIN tipos_habitacion th ON h.tipo_habitacion_id = th.id 
        ORDER BY h.id DESC";

$result = $con->query($sql);

$habitaciones = [];

while ($row = $result->fetch_assoc()) {
    $habitaciones[] = [
        "id" => $row["id"],
        "numero" => $row["numero"],
        "piso" => $row["piso"],
        "tipo" => $row["tipo"]
    ];
}

echo json_encode(["data" => $habitaciones]);
?>
