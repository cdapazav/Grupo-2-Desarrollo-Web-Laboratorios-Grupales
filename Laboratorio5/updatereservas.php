<?php
session_start();
include("conexion.php");

$id = $_POST["id"];
$fecha_ingreso = $_POST["fecha_ingreso"];
$fecha_salida = $_POST["fecha_salida"];

$stmt = $con->prepare("UPDATE reservas SET fecha_ingreso=?, fecha_salida=? WHERE id=? AND usuario_id=?");
$stmt->bind_param("ssii", $fecha_ingreso, $fecha_salida, $id, $_SESSION["id"]);

if ($stmt->execute()) {
  echo json_encode(["status" => "ok", "mensaje" => "Reserva actualizada"]);
} else {
  echo json_encode(["status" => "error", "mensaje" => "No se pudo actualizar"]);
}