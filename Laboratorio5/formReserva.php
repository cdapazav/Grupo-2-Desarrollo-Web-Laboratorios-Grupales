<?php
session_start();
include("conexion.php");
$id_habitacion = isset($_GET['id_habitacion']) ? $_GET['id_habitacion'] : '';
$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '';
$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id_habitacion) {
    $fecha_entrada = $_POST['fecha_entrada'];
    $fecha_salida = $_POST['fecha_salida'];
    $usuario_id = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : 1; // Cambia esto por el id real de usuario logueado
    // Insertar reserva
    $sql = "INSERT INTO reservas (usuario_id, habitacion_id, fecha_ingreso, fecha_salida, estado) VALUES (?, ?, ?, ?, 'confirmada')";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('iiss', $usuario_id, $id_habitacion, $fecha_entrada, $fecha_salida);
    if ($stmt->execute()) {
        $mensaje = '<div style="color:green;font-weight:bold;text-align:center;">¡Reservada con éxito!</div>';
    } else {
        $mensaje = '<div style="color:red;font-weight:bold;text-align:center;">Error al reservar.</div>';
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservar Habitación</title>
    <link rel="stylesheet" href="css/paginaCliente.css">
</head>
<body>
    <div class="contenedor">
        <div class="form-reserva-elegante">
            <h2 class="titulo-reserva">Reservar Habitación</h2>
            <?php if ($mensaje) { echo $mensaje; } ?>
            <?php if (!$mensaje) { ?>
            <form action="" method="post" class="formulario-reserva">
                <?php if ($id_habitacion && $tipo) { ?>
                    <input type="hidden" name="id_habitacion" value="<?php echo htmlspecialchars($id_habitacion); ?>">
                    <input type="hidden" name="tipo_habitacion" value="<?php echo htmlspecialchars($tipo); ?>">
                    <div class="campo-reserva">
                        <label class="label-reserva"><b>Tipo de habitación:</b></label>
                        <span class="valor-reserva"><?php echo htmlspecialchars($tipo); ?></span>
                    </div>
                <?php } ?>
                <div class="campo-reserva">
                    <label for="fecha_entrada" class="label-reserva">Fecha de entrada:</label>
                    <input type="date" id="fecha_entrada" name="fecha_entrada" class="input-reserva" required>
                </div>
                <div class="campo-reserva">
                    <label for="fecha_salida" class="label-reserva">Fecha de salida:</label>
                    <input type="date" id="fecha_salida" name="fecha_salida" class="input-reserva" required>
                </div>
                <button type="submit" class="btn-reserva-elegante">Reservar</button>
            </form>
            <?php } ?>
        </div>
    </div>
    <style>
    .form-reserva-elegante {
        background: #fff;
        max-width: 420px;
        margin: 40px auto 0 auto;
        padding: 36px 32px 28px 32px;
        border-radius: 18px;
        box-shadow: 0 8px 32px rgba(25, 118, 210, 0.18), 0 1.5px 8px rgba(0,0,0,0.08);
        border: 1.5px solid #1976d2;
        font-family: 'Segoe UI', 'Arial', sans-serif;
        position: relative;
        animation: fadeInReserva 0.5s;
    }
    @keyframes fadeInReserva {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .titulo-reserva {
        text-align: center;
        color: #1976d2;
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 28px;
        letter-spacing: 1px;
    }
    .formulario-reserva {
        display: flex;
        flex-direction: column;
        gap: 18px;
    }
    .campo-reserva {
        display: flex;
        flex-direction: column;
        margin-bottom: 8px;
    }
    .label-reserva {
        color: #1976d2;
        font-weight: 600;
        margin-bottom: 6px;
        font-size: 1.08rem;
        letter-spacing: 0.5px;
    }
    .valor-reserva {
        color: #222;
        font-size: 1.08rem;
        background: #e3f0fa;
        border-radius: 8px;
        padding: 8px 12px;
        font-weight: 500;
        border: 1px solid #b3d3f7;
    }
    .input-reserva {
        padding: 10px 14px;
        border-radius: 8px;
        border: 1.5px solid #b3d3f7;
        font-size: 1.08rem;
        background: #f8fbff;
        color: #222;
        transition: border 0.2s, box-shadow 0.2s;
        outline: none;
    }
    .input-reserva:focus {
        border: 1.5px solid #1976d2;
        box-shadow: 0 2px 8px rgba(25,118,210,0.10);
    }
    .btn-reserva-elegante {
        background: linear-gradient(90deg, #1976d2 60%, #64b5f6 100%);
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 12px 0;
        font-size: 1.15rem;
        font-weight: 700;
        margin-top: 18px;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(25,118,210,0.10);
        transition: background 0.2s, transform 0.2s;
    }
    .btn-reserva-elegante:hover {
        background: linear-gradient(90deg, #1565c0 60%, #1976d2 100%);
        transform: translateY(-2px) scale(1.03);
    }
    </style>
</body>
</html>
