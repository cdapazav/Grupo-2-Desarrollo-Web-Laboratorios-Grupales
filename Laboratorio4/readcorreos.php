<?php
session_start();
include("conexion.php");
require("verificarsesion.php");
require("verificarnivel.php"); 

$sql = "SELECT c.id, u1.nombre AS remitente, u2.nombre AS destinatario, c.asunto, c.mensaje, c.fecha_envio 
        FROM correos c
        JOIN usuarios u1 ON c.remitente_id = u1.id
        JOIN usuarios u2 ON c.destinatario_id = u2.id
        ORDER BY c.fecha_envio DESC";

$result = $con->query($sql);
?>

<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Remitente</th>
        <th>Destinatario</th>
        <th>Asunto</th>
        <th>Mensaje</th>
        <th>Fecha de Envío</th>
    </tr>
    <?php while($row = $result->fetch_assoc()){ ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['remitente']; ?></td>
        <td><?php echo $row['destinatario']; ?></td>
        <td><?php echo $row['asunto']; ?></td>
        <td><?php echo $row['mensaje']; ?></td>
        <td><?php echo $row['fecha_envio']; ?></td>
    </tr>
    <?php } ?>
</table>

<?php $con->close(); ?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Listado de Correos</title>
<style>
  body {
    font-family: Arial, sans-serif;
    background-color: #eef2f5;
    justify-content: center;
    align-items: center;
    height: auto;
    margin: 30px;
    margin-left: 500px;

  }
  table {
    background-color: #fff;
    border-collapse: collapse;
    border-radius: 12px;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
    width: 100%;
    max-width: 900px;
    overflow: hidden;
  }
  th, td {
    padding: 12px 15px;
    border-bottom: 1px solid #ccc;
    text-align: left;
    color: #444;
  }
  th {
    background-color: #5ba6d8;
    color: white;
    font-weight: bold;
  }
  tr:hover {
    background-color: #f1f9ff;
  }
  /* Opcional: para que los bordes superiores sean redondeados */
  thead tr th:first-child {
    border-top-left-radius: 12px;
  }
  thead tr th:last-child {
    border-top-right-radius: 12px;
  }
</style>
</head>
<body>

