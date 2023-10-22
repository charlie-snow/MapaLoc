<?php
require_once ("clases/clase.generalista.php");
$generador = new generaLista();

$volver = "";

$mapa = false;
if ($_GET['mapa'] == '1') {
	$mapa = true;
}

$tipos = array();
$tipomapa = '';

if (!isset($_GET['tipo'])) {
	$tipomapa = "lugares";
	$volver .= "lugares";
} else {
	$tipomapa = $_GET['tipo'];
}
if ($tipomapa == "lugares") {
	$tipos = $generador->listaTipos ();
} else {
	$tipos[0]['tipo'] = $tipomapa;
}

// $_SESSION['volver'] = "index.php?contenido=lugares&mapa=".$mapa."&tipo=".$tipomapa."&pais=".$pais;

if ($mapa) {
	$ancho = 450; $arriba = 180; $derecha = 20; $izquierda = 20; $tipo = $tipomapa; include "mapa.php";
}

?>

<?php include "estilos-links.php"; ?>

<?php include("lugares.lista.php"); ?>
