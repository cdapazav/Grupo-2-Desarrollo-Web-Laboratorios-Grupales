<?php
session_start();
include("conexion.php");
require("verificarsesion.php");
require("verificarnivel.php");

$id = $_GET['id'];
$sql = "SELECT id, nombre, correo, nivel FROM usuarios WHERE id = $id";
$resultado = $con->query($sql);
$row = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
    <h2>Editar Usuario</h2>
    <form action="update.php" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" value="<?php echo $row['nombre']; ?>" required><br>

        <label for="correo">Correo:</label>
        <input type="email" name="correo" value="<?php echo $row['correo']; ?>" required><br>

        <label for="password">Contrasena (solo si se quiere cambiarla):</label>
        <input type="password" name="password"><br>

        <label for="nivel">Nivel:</label>
        <select name="nivel" required>
            <option value="0" <?php echo $row['nivel'] == 0 ? 'selected' : ''; ?>>Usuario</option>
            <option value="1" <?php echo $row['nivel'] == 1 ? 'selected' : ''; ?>>Administrador</option>
        </select><br>

        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <input type="submit" value="Guardar cambios">
    </form>
</body>
</html>
