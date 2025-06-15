<?php
session_start();
include("conexion.php");
header('Content-Type: application/json');

$response = [];

if (!isset($_SESSION['id'])) {
    echo json_encode(["status" => "error", "mensaje" => "Debes iniciar sesión."]);
    exit();
}

$usuario_id = $_SESSION['id'];
$habitacion_id = $_POST['habitacion_id'];
$fecha_ingreso = $_POST['fecha_ingreso'];
$fecha_salida = $_POST['fecha_salida'];

$stmt = $con->prepare("SELECT COUNT(*) as total FROM reservas
    WHERE habitacion_id = ?
    AND (
        (fecha_ingreso <= ? AND fecha_salida >= ?) OR
        (fecha_ingreso <= ? AND fecha_salida >= ?)
    )");

$stmt->bind_param("issss", $habitacion_id, $fecha_ingreso, $fecha_ingreso, $fecha_salida, $fecha_salida);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row['total'] > 0) {
    echo json_encode(["status" => "ocupada", "mensaje" => "La habitación ya está reservada para esas fechas."]);
    exit();
}

$stmt1 = $con->prepare("INSERT INTO reservas (usuario_id, habitacion_id, fecha_ingreso, fecha_salida, estado)
                        VALUES (?, ?, ?, ?, 'confirmada')");
$stmt1->bind_param("iiss", $usuario_id, $habitacion_id, $fecha_ingreso, $fecha_salida);

if ($stmt1->execute()) {
    echo json_encode(["status" => "ok", "mensaje" => "Reserva creada correctamente."]);
} else {
    echo json_encode(["status" => "error", "mensaje" => "Error al crear la reserva: " . $stmt1->error]);
}
?>
