<?php
include("conexion.php");
header('Content-Type: application/json');

$sql = "SELECT h.id, h.numero, h.piso, 
               th.nombre AS tipo, th.superficie, th.numero_camas,
               fh.fotografia, fh.orden
        FROM habitaciones h
        JOIN tipos_habitacion th ON h.tipo_habitacion_id = th.id
        LEFT JOIN fotografias_habitacion fh ON h.id = fh.habitacion_id
        ORDER BY h.id DESC, fh.orden ASC";

$result = $con->query($sql);

$habitaciones = [];

while ($row = $result->fetch_assoc()) {
    $id = $row['id'];

    if (!isset($habitaciones[$id])) {
        $habitaciones[$id] = [
            "id" => $row["id"],
            "numero" => $row["numero"],
            "piso" => $row["piso"],
            "tipo" => $row["tipo"],
            "superficie" => $row["superficie"],
            "numero_camas" => $row["numero_camas"],
            "fotos" => []
        ];
    }

    if (!empty($row["fotografia"])) {
        $habitaciones[$id]["fotos"][] = "images/" . $row["fotografia"];
    }
}

echo json_encode(["status" => "ok", "data" => array_values($habitaciones)]);

