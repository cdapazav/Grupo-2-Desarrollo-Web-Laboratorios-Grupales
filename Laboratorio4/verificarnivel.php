<?php
if ($_SESSION["nivel"]==0)
{
    echo "No tienes permiso para acceder a esta página.";
    ?>
    <meta http-equiv="refresh" content="3;url=bandeja.php">
    <?php
    die();
}