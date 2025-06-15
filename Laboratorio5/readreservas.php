<?php
session_start();

include('conexion.php');
include('verificarsesion.php');

header('Content-Type: application/json');

$sql = "SELECT 
            r.id AS reserva_id,
            u.correo AS usuario_correo,
            h.numero AS numero_habitacion,
            th.nombre AS tipo_habitacion,
            r.fecha_ingreso,
            r.fecha_salida,
            r.estado
        FROM reservas r
        JOIN usuarios u ON r.usuario_id = u.id
        JOIN habitaciones h ON r.habitacion_id = h.id
        JOIN tipos_habitacion th ON h.tipo_habitacion_id = th.id
        ORDER BY r.fecha_ingreso DESC";

$result = $con->query($sql);

$array = [];

while ($row = mysqli_fetch_array($result)) {
    $array[] = [
        'reserva_id' => $row['reserva_id'],
        'usuario_correo' => $row['usuario_correo'],
        'numero_habitacion' => $row['numero_habitacion'],
        'tipo_habitacion' => $row['tipo_habitacion'],
        'fecha_ingreso' => $row['fecha_ingreso'],
        'fecha_salida' => $row['fecha_salida'],
        'estado' => $row['estado']
    ];
}

echo json_encode(["data" => $array]);
?>
