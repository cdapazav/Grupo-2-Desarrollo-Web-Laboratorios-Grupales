<?php
include("conexion.php");

$id = $_GET["id"];

// 1. Eliminar fotos físicas
$consultaFotos = $con->prepare("SELECT fotografia FROM fotografias_habitacion WHERE habitacion_id = ?");
$consultaFotos->bind_param("i", $id);
$consultaFotos->execute();
$resultado = $consultaFotos->get_result();

while ($foto = $resultado->fetch_assoc()) {
  $ruta = "images/" . $foto["fotografia"];
  if (file_exists($ruta)) unlink($ruta);
}

// 2. Eliminar registros de fotos
$delFotos = $con->prepare("DELETE FROM fotografias_habitacion WHERE habitacion_id = ?");
$delFotos->bind_param("i", $id);
$delFotos->execute();

// 3. Eliminar habitación
$delHabitacion = $con->prepare("DELETE FROM habitaciones WHERE id = ?");
$delHabitacion->bind_param("i", $id);
$delHabitacion->execute();

echo "Habitación eliminada exitosamente.";
