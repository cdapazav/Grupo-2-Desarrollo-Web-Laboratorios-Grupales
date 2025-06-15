<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Crear Nuevo Usuario</title>
    <style>
      body {
        font-family: Arial, sans-serif;
        background-color: #eef2f5;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
      }
      form {
        background-color: #fff;
        padding: 30px 40px;
        border-radius: 12px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 400px;
      }
      label {
        display: block;
        margin-bottom: 6px;
        font-weight: bold;
        color: #444;
      }
      input[type="text"],
      input[type="email"],
      input[type="password"],
      select {
        width: 100%;
        padding: 12px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 16px;
        box-sizing: border-box;
      }
      input[type="submit"] {
        width: 100%;
        background-color: #5ba6d8;
        color: white;
        padding: 12px;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
      }
      input[type="submit"]:hover {
        background-color: #4a8cc9;
      }
    </style>
</head>
<body>
    <?php 
    session_start();
    require("verificarsesion.php");
    require("verificarnivel.php");
    ?>

    <form action="create.php" method="POST">
        <label for="nombre">Nombres:</label>
        <input type="text" id="nombre" name="nombre" required />

        <label for="correo">Correo Electrónico:</label>
        <input type="email" id="correo" name="correo" required />

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required />

        <label for="nivel">Rol:</label>
        <select id="nivel" name="nivel" required>
            <option value="0">Usuario</option>
            <option value="1">Administrador</option>
        </select>

        <input type="submit" value="Crear Usuario" />
    </form>
</body>
</html>
