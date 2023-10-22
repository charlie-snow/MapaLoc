<?php
include "estilos-links.php";

require_once ("clases/clase.generalista.php");
include_once('kml.class.php');

// variables 
$altitud = 0;

$iconotarget = "https://cdn4.iconfinder.com/data/icons/iconsweets/50/target.png";

$tipo = 'lugares';
$pais = '';

if(isset($_GET['tipo'])){ $tipo = $_GET['tipo']; }
if(isset($_GET['pais'])){ $pais = $_GET['pais']; }

$generador = new generaLista;

// declarar el archivo a crear, y el documento con el que trabajaremos antes
$kml = new KML('KML');
$documentokml = new KMLDocument('kml', 'KML');

// capa sitios
$capasitios = new KMLFolder('', 'sitios');
$style = new KMLStyle('sitio');
$style->setIconStyle($iconotarget, 'ffffffff', 'normal', 1);
$style->setLineStyle('ffffffff', 'normal', 2);
$documentokml->addStyle($style);

// capa sitios
// $capaBR = new KMLFolder('', 'Bares-Restaurantes');
// $capaplayas = new KMLFolder('', 'playas');
// $capafaros = new KMLFolder('', 'faros');

$capa = new KMLFolder('', 'capa');

$lugar;

$resultados = $generador->generarListaLugares ($_SESSION['usuario_id'], false, $tipo, $pais);

for ($i=0/*count($resultados)-5*/; $i<count($resultados); $i++){
	$res = preg_replace("/[^a-zA-Z0-9]/", "", $resultados[$i]['id']);
	$id=$res;
	
	$res = preg_replace("/[^a-zA-Z0-9\s]/", "", $resultados[$i]['nombre']);
	$nombre=$res;
	
	$tipo=$resultados[$i]['tipo'];
	
	$lat=$resultados[$i]['lat'];
	
	$lon=$resultados[$i]['lon'];
	
	$res = preg_replace("/[^a-zA-Z0-9\s]/", "", $resultados[$i]['notas']);
	$notas=$res;

	// lugar

	$lugar = new KMLPlaceMark('', $nombre, $notas, true);
	$lugar->setGeometry(new KMLPoint($lon, $lat, 0));

	$lugar->setStyleUrl('#capa');
	$capa->addFeature($lugar);
	
	// añadirlo a la capa corespondiente
	// switch ($tipo) {
	//    case 'sitio':
	// 		 $lugar->setStyleUrl('#sitio');
	// 		 $capasitios->addFeature($lugar);
	// 		 break;
	//    case 'B-R':
	// 		 $lugar->setStyleUrl('#B-R');
	// 		 $capaBR->addFeature($lugar);
	// 		 break;
	// 	case 'playa':
	// 		 $lugar->setStyleUrl('#playa');
	// 		 $capaplayas->addFeature($lugar);
	// 		 break;
	// 	case 'faro':
	// 		 $lugar->setStyleUrl('#faro');
	// 		 $capafaros->addFeature($lugar);
	// 		 break;
	// }
	
 } 


// añadir la capa al documento
// $documentokml->addFeature($capasitios);
// $documentokml->addFeature($capafaros);
// $documentokml->addFeature($capaplayas);
// $documentokml->addFeature($capaBR);

$documentokml->addFeature($capa);

// enlazar el documento con el kml
$kml->setFeature($documentokml);

echo $kml;

// ver el resultado en texto
echo '<pre>';
echo htmlspecialchars($kml->output('S'));
echo '</pre>';

echo 'fin';

// crea el archivo kml
$nombre_archivo = 'output/lugares en '.$pais.' de '.$_SESSION['usuario_nombre'].'.kml';
$kml->output('F', $nombre_archivo);

?>
