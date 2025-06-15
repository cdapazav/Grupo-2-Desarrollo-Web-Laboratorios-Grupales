<?php
session_start();
include("conexion.php");

$numero = $_POST['numero'];
$piso = $_POST['piso'];
$tipo = $_POST['tipo_habitacion_id'];

// 1. Insertar habitación
$stmt = $con->prepare("INSERT INTO habitaciones (numero, piso, tipo_habitacion_id) VALUES (?, ?, ?)");
$stmt->bind_param("iii", $numero, $piso, $tipo);
$stmt->execute();
$habitacion_id = $stmt->insert_id;

$orden = 1;
foreach ($_FILES['fotos']['tmp_name'] as $i => $tmp_name) {
    $nombre = basename($_FILES['fotos']['name'][$i]);
    $rutaDestino = "images/" . time() . "_" . $nombre;
    move_uploaded_file($tmp_name, $rutaDestino);

    $nombreArchivo = basename($rutaDestino);

    $stmtFoto = $con->prepare("INSERT INTO fotografias_habitacion (habitacion_id, fotografia, orden) VALUES (?, ?, ?)");
    $stmtFoto->bind_param("isi", $habitacion_id, $nombreArchivo, $orden);
    $stmtFoto->execute();

    $orden++;
}


echo "Habitación creada exitosamente.";
