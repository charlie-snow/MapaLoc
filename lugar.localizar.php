<?php
session_start();
require_once ("clases/clase.lugar.php");

$volver = "index.php";
if (isset($_SESSION['volver'])) {
	$volver = $_SESSION['volver'];
    $_SESSION['volver'] = "";
}

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$pais = $_POST['pais'];
$region = $_POST['region'];
$ciudad = $_POST['ciudad'];
$direccion = $_POST['direccion'];

$lugar = new lugar($usuario);
$lugar->actualizarLocalizacion($id, $nombre, $pais, $region, $ciudad, $direccion);

header ("Location:".$volver);
?>
