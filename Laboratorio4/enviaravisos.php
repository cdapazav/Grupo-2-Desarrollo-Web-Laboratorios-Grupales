<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Enviar aviso a todos</title>
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
        box-sizing: border-box;
      }

      label {
        display: block;
        margin-bottom: 6px;
        font-weight: bold;
        color: #444;
      }
      input[type="text"],
      textarea {
        width: 100%;
        padding: 12px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 16px;
        box-sizing: border-box;
        resize: vertical;
      }
      button {
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
      button:hover {
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
    <form action="upd_avisos.php" method="post">
        <label for="asunto">Asunto:</label>
        <input type="text" name="asunto" required />

        <label for="mensaje">Mensaje:</label>
        <textarea name="mensaje" rows="5" cols="40" required></textarea>

        <button type="submit">Enviar aviso</button>
    </form>
</body>
</html>
