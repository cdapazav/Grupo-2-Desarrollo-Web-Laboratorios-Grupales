<?php
session_start();
require("verificarsesion.php");
require("conexion.php");

$orden = "usuarios.id";
$buscar = "";

if (isset($_GET['buscar'])) {
    $buscar = $_GET['buscar'];
}

if (isset($_GET['orden'])) {
    $orden = $_GET['orden'];
}

$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

$sql2 = "SELECT COUNT(*) as total FROM usuarios 
         WHERE nombre LIKE '%$buscar%' OR correo LIKE '%$buscar%'";

$resultado2 = $con->query($sql2);
$row2 = mysqli_fetch_array($resultado2);
$total = $row2['total'];
$nropaginas = ceil($total / 5);
$inicio = ($pagina - 1) * 5;

$sql = "SELECT id, nombre, correo, nivel, Estado FROM usuarios 
        WHERE nombre LIKE '%$buscar%' OR correo LIKE '%$buscar%' 
        ORDER BY $orden 
        LIMIT $inicio, 5";

$resultado = $con->query($sql);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f1f3f4;
            padding: 20px;
            margin: 0;
            color: #202124;
        }

        h1,
        label {
            color: #202124;
        }

        form {
            margin-bottom: 20px;
            text-align: center;
        }

        input[type="text"] {
            padding: 10px;
            width: 300px;
            border: 1px solid #dadce0;
            border-radius: 4px;
            font-size: 16px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #1a73e8;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            margin-left: 10px;
        }

        input[type="submit"]:hover {
            background-color: #1669c1;
        }

        table.container {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            margin: auto;
        }

        thead {
            background-color: #e8eaed;
        }

        thead th {
            padding: 12px;
            text-align: left;
            color: #5f6368;
            font-weight: 500;
        }

        td {
            padding: 12px;
            border-top: 1px solid #e0e0e0;
        }

        .container a {
            text-decoration: none;
            color: #1a73e8;
            font-weight: 500;
        }

        .container a:hover {
            text-decoration: underline;
        }

        .insertar,
        .cerrar {
            display: inline-block;
            background-color: #1a73e8;
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 4px;
            margin: 10px 5px;
            font-weight: 500;
        }

        .insertar:hover,
        .cerrar:hover {
            background-color: #155ab6;
        }

        ul {
            padding: 0;
            margin: 20px 0;
            display: flex;
            justify-content: center;
            list-style: none;
        }

        ul li a {
            padding: 8px 12px;
            margin: 0 5px;
            background-color: #e8eaed;
            color: #202124;
            border-radius: 4px;
            text-decoration: none;
        }

        ul li a:hover {
            background-color: #d2e3fc;
            color: #1a73e8;
        }
    </style>
</head>

<body>

    <h1 style="text-align:center;">Lista de Usuarios</h1>

    <form action="read.php" method="get">
        <label for="buscar">Buscar:</label>
        <input type="text" name="buscar" placeholder="Buscar por nombre o correo"
            value="<?php echo htmlspecialchars($buscar); ?>">
        <input type="submit" value="Buscar">
    </form>

    <table class="container" border="1">
        <thead>
            <tr>
                <th><a href="read.php?orden=nombre&buscar=<?php echo $buscar; ?>">Nombre</a></th>
                <th><a href="read.php?orden=correo&buscar=<?php echo $buscar; ?>">Correo</a></th>
                <th><a href="read.php?orden=nivel&buscar=<?php echo $buscar; ?>">Rol</a></th>
                <th><a href="read.php?orden=Estado&buscar=<?php echo $buscar; ?>">Estado</a></th>
                <th>Cambiar Estado</th>
                <th>Operaciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_array($resultado)) { ?>
                <tr>
                    <td><?php echo ($row['nombre']); ?></td>
                    <td><?php echo ($row['correo']); ?></td>
                    <td><?php echo ($row['nivel'] == 1) ? "Administrador" : "Usuario"; ?></td>
                    <td><?php echo ($row['Estado'] == 0) ? "Activo" : "Inactivo"; ?></td>
                        <td>
                            <?php if ($row['Estado'] == 0): ?>
                                <a href="cambiarestado.php?id=<?php echo $row['id']; ?>&estado=1"
                                    onclick="return confirm('¿Estás seguro de desactivar este usuario?');">Desactivar</a>
                            <?php else: ?>
                                <a href="cambiarestado.php?id=<?php echo $row['id']; ?>&estado=0"
                                    onclick="return confirm('¿Deseas activar este usuario?');">Activar</a>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="formupdate.php?id=<?php echo $row['id']; ?>">Editar</a> |
                            <a href="delete.php?id=<?php echo $row['id']; ?>"
                                onclick="return confirm('¿Estás seguro de eliminar este usuario?');">Eliminar</a>
                        </td>
                    <?php ?>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <ul>
        <li><a
                href="read.php?pagina=<?php echo max(1, $pagina - 1); ?>&orden=<?php echo $orden; ?>&buscar=<?php echo $buscar; ?>">Anterior</a>
        </li>
        <li><a
                href="read.php?pagina=<?php echo min($pagina + 1, $nropaginas); ?>&orden=<?php echo $orden; ?>&buscar=<?php echo $buscar; ?>">Siguiente</a>
        </li>

        <?php for ($i = 1; $i <= $nropaginas; $i++) { ?>
            <li><a
                    href="read.php?pagina=<?php echo $i; ?>&orden=<?php echo $orden; ?>&buscar=<?php echo $buscar; ?>"><?php echo $i; ?></a>
            </li>
        <?php } ?>
    </ul>
    <div style="text-align:center;">
        <a class="insertar" href="readcorreos.php">Revisar Correos</a>
        <a class="insertar" href="enviaravisos.php">Enviar Avisos</a>
    </div>

    <div style="text-align:center;">
        <a class="insertar" href="forminsertar.php">Insertar Usuario</a>
        <a class="cerrar" href="exit.php">Cerrar Sesión</a>
    </div>

</body>

</html>