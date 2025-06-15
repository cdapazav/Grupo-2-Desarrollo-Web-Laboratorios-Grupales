<?php
session_start();
include("conexion.php");
header("Content-Type: application/json");

if (!isset($_SESSION["id"])) {
  echo json_encode(["status" => "error", "mensaje" => "No autenticado"]);
  exit();
}

$usuario_id = $_SESSION["id"];

$sql = "SELECT 
          r.id AS reserva_id,
          h.numero AS numero_habitacion,
          th.nombre AS tipo_habitacion,
          r.fecha_ingreso,
          r.fecha_salida,
          r.estado
        FROM reservas r
        JOIN habitaciones h ON r.habitacion_id = h.id
        JOIN tipos_habitacion th ON h.tipo_habitacion_id = th.id
        WHERE r.usuario_id = ?
        ORDER BY r.fecha_ingreso DESC";

$stmt = $con->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

$reservas = [];
while ($row = $result->fetch_assoc()) {
  $reservas[] = $row;
}

echo json_encode(["status" => "ok", "data" => $reservas]);
?>
