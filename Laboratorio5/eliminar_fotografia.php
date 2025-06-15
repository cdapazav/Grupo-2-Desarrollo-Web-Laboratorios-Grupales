<?php
include('conexion.php');

if (isset($_POST['foto_id'])) {
    $id = intval($_POST['foto_id']);

    $foto_sql = $con->prepare("SELECT fotografia FROM fotografias_habitacion WHERE id = ?");
    $foto_sql->bind_param("i", $id);
    $foto_sql->execute();
    $foto_sql->bind_result($nombre_foto);
    $foto_sql->fetch();
    $foto_sql->close();

    if ($nombre_foto && file_exists("images/" . $nombre_foto)) {
        unlink("images/" . $nombre_foto);
    }

    $stmt = $con->prepare("DELETE FROM fotografias_habitacion WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}


header("Location: subir_fotografia.php");
exit;
?>
