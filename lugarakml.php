<?php
include_once('kml.class.php');

// variables
$nombrecapa = 'capa';
$nombre = 'aguascaidas';
$lat = 42.5175246;
$lon = -7.7121395;
$descripcion = 'descripcion';
$altitud = 0;

// crear el archico a crear, y el documento conel que trabajamos antes
$kml = new KML('KML');
$documentokml = new KMLDocument('kml', 'KML');

// capa
$capa = new KMLFolder('', $nombrecapa);

// lugar
$lugar = new KMLPlaceMark('', $nombre, $descripcion, true);
$lugar->setGeometry(new KMLPoint($lon, $lat, 0));
// añadirlo a la capa
$capa->addFeature($lugar);

// añadir la capa al documento
$documentokml->addFeature($capa);

// enlazar el documento con el kml
$kml->setFeature($documentokml);

// ver el resultado en texto
echo '<pre>';
echo htmlspecialchars($kml->output('S'));
echo '</pre>';


// crea el archivo kml
$kml->output('F', 'output/test.kml');

?>
