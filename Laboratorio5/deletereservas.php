<?php
session_start();
include("conexion.php");

$id = $_GET["id"];
$usuario = $_SESSION["id"];

$stmt = $con->prepare("DELETE FROM reservas WHERE id=? AND usuario_id=?");
$stmt->bind_param("ii", $id, $usuario);

if ($stmt->execute()) {
  echo json_encode(["status" => "ok", "mensaje" => "Reserva eliminada"]);
} else {
  echo json_encode(["status" => "error", "mensaje" => "Error al eliminar"]);
}