<?php
include("conexion.php");
$sql = "SELECT r.id, r.fecha_ingreso, r.fecha_salida, th.nombre AS tipo_habitacion, r.estado
        FROM reservas r
        JOIN habitaciones h ON r.habitacion_id = h.id
        JOIN tipos_habitacion th ON h.tipo_habitacion_id = th.id
        ORDER BY r.fecha_ingreso DESC";
$result = $con->query($sql);
?>
<div class="contenedor-reservas" style="padding:32px;">
    <h2 style="text-align:center; color:#1976d2; margin-bottom:24px;">Reservas Realizadas</h2>
    <table class="tabla-habitaciones" style="width:100%;margin:auto;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha de Entrada</th>
                <th>Fecha de Salida</th>
                <th>Tipo de Habitación</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
        <?php while($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['fecha_ingreso']; ?></td>
                <td><?php echo $row['fecha_salida']; ?></td>
                <td><?php echo $row['tipo_habitacion']; ?></td>
                <td><?php echo ucfirst($row['estado']); ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<?php $con->close(); ?>
