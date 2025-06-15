<?php
session_start();
require("conexion.php");
require("verificarsesion.php");

$mi_id = $_SESSION['id'];

$query = $con->prepare("SELECT id, nombre FROM usuarios WHERE id != ?");
$query->bind_param("i", $mi_id);
$query->execute();
$usuarios = $query->get_result();

if (isset($_POST['destinatario']) && isset($_POST['asunto']) && isset($_POST['mensaje'])) {
    $destinatario_id = $_POST['destinatario'];
    $asunto = $_POST['asunto'];
    $mensaje = $_POST['mensaje'];
    $fecha = date('Y-m-d H:i:s'); 

    if ($destinatario_id != "" && $asunto != "" && $mensaje != "") {
        $stmt = $con->prepare("INSERT INTO correos (remitente_id, destinatario_id, asunto, mensaje, fecha_envio, estado) VALUES (?, ?, ?, ?, ?, 'no_leido')");
        $stmt->bind_param("iisss", $mi_id, $destinatario_id, $asunto, $mensaje, $fecha);
        if ($stmt->execute()) {
            $mensaje_exito = "Correo enviado correctamente.";
        } else {
            $mensaje_error = "Error al enviar el correo: " . $stmt->error;
        }
    } else {
        $mensaje_error = "Por favor, completa todos los campos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<style>
        body {
        font-family: Arial, sans-serif;
        background-color: #f9f9f9;
        margin: 20px;
    }

    h2 {
        color: #333;
    }

    form {
        background-color: #fff;
        padding: 20px;
        border: 1px solid #ccc;
        max-width: 500px;
        border-radius: 5px;
        box-shadow: 0 0 8px rgba(0,0,0,0.1);
    }

    label {
        font-weight: bold;
        display: block;
        margin-bottom: 6px;
        color: #555;
    }

    select, input[type="text"], textarea {
        width: 100%;
        padding: 8px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 1em;
        box-sizing: border-box;
        resize: vertical;
    }

    button {
        background-color: #2c7efc;
        color: white;
        border: none;
        padding: 10px 18px;
        font-size: 1em;
        cursor: pointer;
        border-radius: 4px;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #1a5edb;
    }

    a {
        display: inline-block;
        margin-top: 15px;
        color: #2c7efc;
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }

    p {
        font-size: 0.9em;
        margin-top: 10px;
    }

    p[style*="color:red"] {
        color: #d93025;
        font-weight: bold;
    }

    p[style*="color:green"] {
        color: #188038;
        font-weight: bold;
    }
</style>
<body>
    <h2>Enviar Correo</h2>

    <?php if (isset($mensaje_exito)) echo "<p style='color:green;'>$mensaje_exito</p>"; ?>
    <?php if (isset($mensaje_error)) echo "<p style='color:red;'>$mensaje_error</p>"; ?>

    <form method="post" action="enviarcorreos.php">
        <label for="destinatario">Destinatario:</label>
        <select name="destinatario" id="destinatario" required>
            <option value="">Selecciona un usuario</option>
            <?php while ($row = $usuarios->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <label for="asunto">Asunto:</label><br>
        <input type="text" id="asunto" name="asunto" required>
        <br><br>

        <label for="mensaje">Mensaje:</label><br>
        <textarea id="mensaje" name="mensaje" rows="6" cols="50" required></textarea>
        <br><br>
        <button type="submit">Enviar</button>
    </form>

    <a href="bandeja.php">Volver a bandeja</a>
</body>
</html>
