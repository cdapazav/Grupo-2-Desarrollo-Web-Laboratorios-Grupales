<?php
session_start();
require("conexion.php");
require("verificarsesion.php");

$id = $_SESSION['id'];
//??
if (isset($_POST['marcar_leido_id'])) {
    $correo_id = intval($_POST['marcar_leido_id']);
    $stmt = $con->prepare("UPDATE correos SET estado='leido' WHERE id=? AND destinatario_id=?");
    $stmt->bind_param("ii", $correo_id, $id);
    $stmt->execute();
    echo "ok";
    exit;
}

$stmt_in = $con->prepare("SELECT c.id, u_remitente.nombre AS remitente, c.asunto, c.mensaje, c.fecha_envio, c.estado
    FROM correos c
    INNER JOIN usuarios u_remitente ON c.remitente_id = u_remitente.id
    WHERE c.destinatario_id = ?
    ORDER BY c.fecha_envio DESC
");
$stmt_in->bind_param("i", $id);
$stmt_in->execute();
$inbox = $stmt_in->get_result();

//salida
$stmt_out = $con->prepare("
    SELECT c.id, u_destinatario.nombre AS destinatario, c.asunto, c.mensaje, c.fecha_envio, c.estado
    FROM correos c
    INNER JOIN usuarios u_destinatario ON c.destinatario_id = u_destinatario.id
    WHERE c.remitente_id = ?
    ORDER BY c.fecha_envio DESC
");
$stmt_out->bind_param("i", $id);
$stmt_out->execute();
$outbox = $stmt_out->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Bandeja de Correos</title>
<style>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #eef2f5;
        margin: 20px;
        color: #333;
    }
    h2 {
        color: #222;
        margin-bottom: 15px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 40px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        background-color: #fff;
        border-radius: 8px;
        overflow: hidden;
    }
    th, td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
        font-size: 15px;
    }
    th {
        background-color: #5ba6d8;
        color: white;
        font-weight: 600;
    }
    tr.leido {
        background-color: #f5f7fa;
        color: #666;
        font-weight: normal;
    }
    tr.no-leido {
        font-weight: bold;
        background-color: #fff;
        color: #222;
    }
    tr:hover {
        background-color: #d9e7ff;
    }
    a {
        color: #5ba6d8;
        text-decoration: none;
        font-weight: 600;
    }
    a:hover {
        text-decoration: underline;
    }
    button {
        background-color: #5ba6d8;
        color: white;
        border: none;
        padding: 8px 14px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        transition: background-color 0.3s ease;
    }
    button:hover {
        background-color: #4a8cc9;
    }
    /* Modal styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0; top: 0;
        width: 100%; height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.5);
        font-family: Arial, sans-serif;
    }
    .modal-content {
        background-color: #fff;
        margin: 10% auto;
        padding: 25px 30px;
        border-radius: 12px;
        width: 90%;
        max-width: 600px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        position: relative;
    }
    #cerrarModal {
        position: absolute;
        top: 12px;
        right: 20px;
        font-size: 28px;
        font-weight: bold;
        color: #999;
        cursor: pointer;
        transition: color 0.3s ease;
    }
    #cerrarModal:hover {
        color: #555;
    }
    #modalAsunto {
        margin-top: 0;
        margin-bottom: 15px;
        font-size: 24px;
        color: #333;
    }
    #modalMensaje {
        font-size: 16px;
        white-space: pre-wrap;
        line-height: 1.5;
        color: #444;
    }
</style>

</head>
<body>

<?php

echo  $correo = $_SESSION['correo'];

?>
<h2>Bandeja de Entrada</h2>
<table id="tabla-inbox">
    <thead>
        <tr>
            <th>Remitente</th>
            <th>Asunto</th>
            <th>Fecha</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    <?php while ($row = $inbox->fetch_assoc()): ?>
        <tr data-id="<?php echo $row['id']; ?>" class="<?php echo ($row['estado'] === 'leido') ? 'leido' : 'no-leido'; ?>">
            <td><?php echo $row['remitente']; ?></td>
            <td><?php echo $row['asunto']; ?></td>
            <td><?php echo $row['fecha_envio']; ?></td>
                <td>
                    <button class="ver-correo" data-id="<?php echo $row['id']; ?>" data-mensaje="<?php echo $row['mensaje']; ?>" data-asunto="<?php echo $row['asunto']; ?>">Ver</button>
                    <a href="elimcorreo.php?id=<?php echo $row['id']; ?>" onclick="return confirm('¿Seguro que quieres eliminar este correo?');">Eliminar</a>
                </td>

        </tr>
    <?php endwhile; ?>
    </tbody>
</table>

<h2>Bandeja de Salida</h2>
<table id="tabla-outbox">
    <thead>
        <tr>
            <th>Estado</th>
            <th>Destinatario</th>
            <th>Asunto</th>
            <th>Fecha</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    <?php while ($row = $outbox->fetch_assoc()): ?>
        <tr>
            <td><?php echo ($row['estado'] === 'leido') ? 'Leído' : 'No leído'; ?></td>
            <td><?php echo $row['destinatario']; ?></td>
            <td><?php echo $row['asunto']; ?></td>
            <td><?php echo $row['fecha_envio']; ?></td>
           <td>
                <button class="ver-correo" data-id="<?php echo $row['id']; ?>" data-mensaje="<?php echo $row['mensaje']; ?>" data-asunto="<?php echo $row['asunto']; ?>">Ver</button>
                <a href="elimcorreo.php?id=<?php echo $row['id']; ?>" onclick="return confirm('¿Seguro que quieres eliminar este correo?');">Eliminar</a>
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>
<a href="enviarcorreos.php">Enviar Nuevo Correo</a>



<div id="modalCorreo" class="modal">
  <div class="modal-content">
    <span id="cerrarModal" style="float:right;cursor:pointer;">&times;</span>
    <h3 id="modalAsunto"></h3>
    <p id="modalMensaje"></p>
  </div>
</div>

<script>
document.querySelectorAll('.ver-correo').forEach(button => {
    button.addEventListener('click', function() {
        const id = this.dataset.id;
        const asunto = this.dataset.asunto;
        const mensaje = this.dataset.mensaje;

        document.getElementById('modalAsunto').textContent = asunto;
        document.getElementById('modalMensaje').textContent = mensaje;

        // Mostrar modal
        document.getElementById('modalCorreo').style.display = 'block';

        // Cambiar estilo fila y marcar como leído solo en bandeja de entrada
        let fila = this.closest('tr');
        if(fila.classList.contains('no-leido')) {
            fila.classList.remove('no-leido');
            fila.classList.add('leido');

            // Marcar como leído en BD via AJAX
            fetch('bandeja.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'marcar_leido_id=' + id
            }).then(response => response.text())
              .then(data => {
                  if(data !== 'ok') {
                      alert('Error al marcar como leído');
                  }
              });
        }
    });
});

document.getElementById('cerrarModal').addEventListener('click', function() {
    document.getElementById('modalCorreo').style.display = 'none';
});
window.onclick = function(event) {
    let modal = document.getElementById('modalCorreo');
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

</body>
</html>
