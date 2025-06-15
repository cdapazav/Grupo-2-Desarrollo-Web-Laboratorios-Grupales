<h4>Crear Habitación</h4>
<form id="formCrearHabitacion" enctype="multipart/form-data">
  <div class="row">
    <div class="col-md-3">
      <label>Número</label>
      <input type="number" name="numero" class="form-control" required>
    </div>
    <div class="col-md-3">
      <label>Piso</label>
      <input type="number" name="piso" class="form-control" required>
    </div>
    <div class="col-md-3">
      <label>Tipo de habitación</label>
      <select name="tipo_habitacion_id" class="form-select" required>
        <?php
        include("conexion.php");
        $tipos = $con->query("SELECT id, nombre FROM tipos_habitacion");
        while ($row = $tipos->fetch_assoc()) {
          echo "<option value='{$row['id']}'>{$row['nombre']}</option>";
        }
        ?>
      </select>
    </div>
    <div class="col-md-3">
      <label>Fotos</label>
      <input type="file" name="fotos[]" class="form-control" multiple accept="image/*" required>
    </div>
  </div>
  <button type="submit" class="btn btn-dark mt-3">Crear Habitación</button>
</form>

<!-- Modal Editar Habitación -->
<div class="modal fade" id="modalEditarHabitacion" tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content" id="formEditarHabitacion">
      <div class="modal-header">
        <h5 class="modal-title">Editar Habitación</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id" id="editarId">

        <div class="mb-3">
          <label for="editarNumero" class="form-label">Número</label>
          <input type="number" class="form-control" name="numero" id="editarNumero" required>
        </div>

        <div class="mb-3">
          <label for="editarPiso" class="form-label">Piso</label>
          <input type="number" class="form-control" name="piso" id="editarPiso" required>
        </div>

        <div class="mb-3">
          <label for="editarTipo" class="form-label">Tipo de Habitación</label>
          <select class="form-select" name="tipo_habitacion_id" id="editarTipo" required>
            <?php
            include("conexion.php");
            $tipos = $con->query("SELECT id, nombre FROM tipos_habitacion");
            while ($row = $tipos->fetch_assoc()) {
              echo "<option value='{$row['id']}'>{$row['nombre']}</option>";
            }
            ?>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Guardar cambios</button>
      </div>
    </form>
  </div>
</div>

<div id="respuestaHabitacion" class="mt-2 text-danger fw-bold text-center"></div>


<div id="tablaHabitaciones" class="mt-4"></div>

<div id="contenedorFotos" class="mt-4"></div>
