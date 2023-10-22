<p><big>LOCALIZACIÓN AUTOMÁTICA POR MAPQUEST</big></p>

<?php 
require_once ("clases/clase.generalista.php");
require_once ("clases/clase.localizador.php");
require_once ("clases/clase.lugar.php");
$generador = new generaLista($usuario);
$localizador = new localizador;

$_SESSION['volver'] = "index.php?contenido=lugares";
?>

<link rel="STYLESHEET" type="text/css" href="scripts/flags/flags.css">

<?php
$resultados = $generador->generarListaLugaresNoLocalizados (0, true, 'lugares');

for ($i=0; $i<count($resultados); $i++){
	$id=$resultados[$i]['id'];
	$nombre=$resultados[$i]['nombre'];
	$tipo=$resultados[$i]['tipo'];
	$lat=$resultados[$i]['lat'];
	$lon=$resultados[$i]['lon'];
	$notas=$resultados[$i]['notas'];

	echo "localizar: ".$nombre."<br>";
	$localizador = new localizador;
	$localizador->direccionDelPunto($lon, $lat);

	$pais = $localizador->pais;
	$region = $localizador->region;
	$ciudad = $localizador->ciudad;
	$direccion = $localizador->direccion;

	$lugar = new lugar($usuario);
	$lugar->actualizarLocalizacion($id, $nombre, $pais, $region, $ciudad, $direccion);

} ?>