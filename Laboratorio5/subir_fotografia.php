<?php
include("conexion.php");

// Consulta de reservas (no se usa visualmente aquí, pero la mantengo por si la necesitas después)
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

// Consulta de imágenes por habitación
$sql = "SELECT 
            f.id AS foto_id, 
            f.fotografia, 
            f.orden, 
            h.numero AS numero_habitacion
        FROM fotografias_habitacion f
        JOIN habitaciones h ON f.habitacion_id = h.id
        ORDER BY h.numero ASC, f.orden ASC";
$result = $con->query($sql);

$imagenes_por_habitacion = [];
while ($row = $result->fetch_assoc()) {
    $numero = $row['numero_habitacion'];
    $imagenes_por_habitacion[$numero][] = $row;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Fotografías de Habitaciones</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>



  <div class="container my-5">

    <h3 class="mb-4 text-center">Agregar Fotografía a Habitación</h3>
    <form class="row g-3" action="panel_adm.php" method="POST" enctype="multipart/form-data">
      <div class="col-md-4">
        <label class="form-label">Habitación</label>
        <select name="habitacion_id" class="form-select" required>
          <?php
          $habitaciones_query = $con->query("SELECT id, numero FROM habitaciones ORDER BY numero ASC");
          while ($hab = $habitaciones_query->fetch_assoc()) {
            echo "<option value='{$hab['id']}'>Habitación {$hab['numero']}</option>";
          }
          ?>
        </select>
      </div>
      <div class="col-md-4">
        <label class="form-label">Fotografía</label>
        <input type="file" name="foto" class="form-control" accept="image/*" required>
      </div>
      <div class="col-md-2">
        <label class="form-label">Orden</label>
        <input type="number" name="orden" class="form-control" value="1" required>
      </div>
      <div class="col-md-2 d-flex align-items-end">
        <button type="submit" class="btn btn-dark w-100">Subir</button>
      </div>
    </form>

    <hr class="my-5">

    <h3 class="text-center mb-4">Eliminar Fotografías por Habitación</h3>

    <?php foreach ($imagenes_por_habitacion as $habitacion => $imagenes): ?>
      <div class="mb-4 p-3 border rounded">
        <h5 class="fw-bold mb-3">Habitación <?= $habitacion ?></h5>
        <div class="row">
          <?php foreach ($imagenes as $img): ?>
            <div class="col-md-3 text-center mb-3">
              <img src="images/<?= htmlspecialchars($img['fotografia']) ?>" class="img-fluid rounded mb-2 border" style="height: 100px; object-fit: cover;">
              <form action="eliminar_fotografia.php" method="POST" onsubmit="return confirm('¿Eliminar esta fotografía?');">
                <input type="hidden" name="foto_id" value="<?= $img['foto_id'] ?>">
                <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
              </form>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
