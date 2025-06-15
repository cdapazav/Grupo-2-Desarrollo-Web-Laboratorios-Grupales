<?php session_start();
include("conexion.php");

// Obtener todas las habitaciones primero
$habitaciones = [];
$sql_habs = "SELECT h.id AS id_habitacion, th.id AS tipo_h_id, h.piso AS piso, th.nombre as tipo, h.precio as precio, th.descripcion as descripcion
            FROM habitaciones h
            JOIN tipos_habitacion th ON th.id=h.tipo_habitacion_id";
if (isset($_GET['tipo']) && $_GET['tipo'] !== "") {
    $sql_habs .= " WHERE th.nombre = ?";
    $stmt = $con->prepare($sql_habs);
    $stmt->bind_param("s", $_GET['tipo']);
    $stmt->execute();
    $result_habs = $stmt->get_result();
} else {
    $result_habs = $con->query($sql_habs);
}
while ($hab = $result_habs->fetch_assoc()) {
    $habitaciones[$hab['id_habitacion']] = $hab;
}
// Obtener todas las fotos de las habitaciones
$fotos = [];
$ids = array_keys($habitaciones);
if (count($ids) > 0) {
    $in = implode(',', array_fill(0, count($ids), '?'));
    $types = str_repeat('i', count($ids));
    $sql_fotos = "SELECT habitacion_id, fotografia FROM fotografias_habitacion WHERE habitacion_id IN ($in) ORDER BY orden, id";
    $stmt_fotos = $con->prepare($sql_fotos);
    $stmt_fotos->bind_param($types, ...$ids);
    $stmt_fotos->execute();
    $result_fotos = $stmt_fotos->get_result();
    while ($row = $result_fotos->fetch_assoc()) {
        $fotos[$row['habitacion_id']][] = $row['fotografia'];
    }
}
?>
<div class="habitaciones-lista" style="display: flex; margin-top: 40px; flex-wrap: wrap; gap: 32px; justify-content: flex-start; width:100%;">
<?php foreach ($habitaciones as $id_hab => $hab) { ?>
    <div class="habitacion-card">
        <div class="habitacion-card-img">
            <div class="carrusel" id="carrusel-<?php echo $id_hab; ?>">
                <?php if (!empty($fotos[$id_hab])) {
                    foreach ($fotos[$id_hab] as $idx => $foto) { ?>
                        <img src="images/<?php echo $foto; ?>" class="img-tabla carrusel-img<?php echo $idx === 0 ? ' active' : ''; ?>" style="display:<?php echo $idx === 0 ? 'block' : 'none'; ?>;" />
                    <?php }
                } else { ?>
                    <img src="images/400.png" class="img-tabla carrusel-img active" style="display:block;" />
                <?php } ?>
                <?php if (!empty($fotos[$id_hab]) && count($fotos[$id_hab]) > 1) { ?>
                    <button class="carrusel-btn prev" onclick="moverCarrusel(<?php echo $id_hab; ?>, -1)">&#10094;</button>
                    <button class="carrusel-btn next" onclick="moverCarrusel(<?php echo $id_hab; ?>, 1)">&#10095;</button>
                <?php } ?>
            </div>
        </div>
        <div class="habitacion-card-body" style="padding: 18px 24px; display: flex; flex-direction: column; gap: 10px;">
            <div class="habitacion-nombre" style="font-size: 1.25rem; font-weight: 700; color: #1976d2; letter-spacing: 1px;">Habitación <?php echo $id_hab; ?></div>
            <div class="habitacion-tipo" style="font-size: 1.08rem; color: #222;"><b>Tipo de cama:</b> <?php echo $hab['tipo']; ?></div>
            <div class="habitacion-precio" style="font-size: 1.08rem; color: #222;"><b>Precio:</b> <?php echo $hab['precio']; ?></div>
            <div class="habitacion-piso" style="font-size: 1.08rem; color: #222;"><b>Piso:</b> <?php echo $hab['piso']; ?></div>
            <div class="habitacion-descripcion" style="font-size: 0.98rem; color: #444;"><b>Descripción:</b> <?php echo $hab['descripcion']; ?></div>
            <div class="habitacion-acciones" style="margin-top: 12px;">
                <button class="btn-reservar" onclick="abrirModalReserva(<?php echo $id_hab; ?>, this)">Disponible</button>
                <div class="fechas-reserva-info" style="display:none; font-size:0.85em; color:#b71c1c; margin-top:6px;"></div>
            </div>
        </div>
    </div>
<?php } ?>
</div>
<?php
if (isset($stmt)) $stmt->close();
if (isset($stmt_fotos)) $stmt_fotos->close();
$con->close();
?>