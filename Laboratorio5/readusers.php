<?php session_start();
    
include('conexion.php');
include('verificarsesion.php');



$orden = "correo";
$buscar = "";
if (isset($_GET["buscar"]))
{
    $buscar=$_GET["buscar"];
}
if  (isset($_GET['orden']))
{
    $orden = $_GET['orden'];
}
if (isset($_GET['asendente']))
{

    $asente= $_GET['asendente'];
} else
{
    $asente= "asc";
}
if (isset($_GET["pagina"]))
{
    $pagina=$_GET["pagina"];
} else
{
    $pagina=1;
}


$sql2="SELECT COUNT(*) as total FROM usuarios WHERE  correo like '%$buscar%'";
$resultado2=$con->query($sql2);
$row2=mysqli_fetch_array($resultado2);
$total=$row2['total'];
$nropaginas = $total / 5;
$nropaginas = ceil($nropaginas);
$inicio = ($pagina-1) * 5;

$sql="SELECT id,correo,rol FROM usuarios 
WHERE correo LIKE '%$buscar%' ORDER BY $orden $asente LIMIT $inicio, 5";
$resultado = $con->query($sql);
$array = [];
while ($row = mysqli_fetch_array($resultado)) {
    $array[] = [
        'id' => $row['id'],
        'correo' => $row['correo'],
        'rol' => $row['rol']
    ];
}
$newarray = [
    "data" => $array,
    "buscar" => $buscar,
    "pagina" => $pagina,
    "orden" => $orden,
    "nropaginas" => $nropaginas
];
echo json_encode($newarray);
?>





