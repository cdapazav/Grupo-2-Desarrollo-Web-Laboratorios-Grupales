<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<div class="container mt-5">
  <h2 class="text-center mb-4">Mis Reservas</h2>
  <div id="tablaReservas"></div>
</div>

<!-- Modal para editar reserva -->
<div class="modal fade" id="modalEditarReserva" tabindex="-1">
  <div class="modal-dialog">
    <form id="formEditarReserva" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Editar Reserva</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="editarReservaId" name="id">
        <label>Fecha de Ingreso</label>
        <input type="date" class="form-control mb-2" name="fecha_ingreso" id="editarFechaIngreso" required>
        <label>Fecha de Salida</label>
        <input type="date" class="form-control" name="fecha_salida" id="editarFechaSalida" required>
        <div class="text-danger mt-2" id="errorEditarReserva"></div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
      </div>
    </form>
  </div>
</div>

<script src="script.js"></script>