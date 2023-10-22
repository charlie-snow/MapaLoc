<?php
include_once('kml.class.php');

// variables
$nombrecapa = 'capa';
$nombre = 'aguascaidas';
$lat = 42.5175246;
$lon = -7.7121395;
$descripcion = 'descripcion';
$altitud = 0;

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

/*
// track
$lugarTrace = new KMLPlaceMark(null, 'track', '', true);
$lugarTrace->setGeometry (new KMLLineString( Array (
                           array ( 4, 3,0),
                           array ( 2, 4,0),
                           array (-1, 3,0),
                           array (-1, 2,0)
                        ), true, '', true)
                     );
$lugarTrace->setTimePrimitive(new KMLTimeStamp('','2008-05-01','2008-05-25'));

$lugarFolder->addFeature($lugarTrace); // ??

//Ajout de l'historique des positions
$lugarHistoFolder = new KMLFolder('', 'Historique des positions');


$lugarFollow = new KMLPlaceMark('', '1', '', true);
$lugarFollow->setGeometry(new KMLPoint( 4, 3, 0));
$lugarFollow->setStyleUrl('#plotStyle');
$lugarFollow->setTimePrimitive(new KMLTimeStamp('','2008-05-01'));
$lugarHistoFolder->addFeature($lugarFollow);

$lugarFollow = new KMLPlaceMark('', '2', '', true);
$lugarFollow->setGeometry(new KMLPoint( 2, 4, 0));
$lugarFollow->setStyleUrl('#plotStyle');
$lugarFollow->setTimePrimitive(new KMLTimeStamp('','2008-05-05'));
$lugarHistoFolder->addFeature($lugarFollow);

$lugarFollow = new KMLPlaceMark('', '3', '', true);
$lugarFollow->setGeometry(new KMLPoint(-1, 3, 0));
$lugarFollow->setStyleUrl('#plotStyle');
$lugarFollow->setTimePrimitive(new KMLTimeStamp('','2008-05-15'));
$lugarHistoFolder->addFeature($lugarFollow);

$lugarFollow = new KMLPlaceMark('', '4', '', true);
$lugarFollow->setGeometry(new KMLPoint(-1, 2, 0));
$lugarFollow->setStyleUrl('#plotStyle');
$lugarFollow->setTimePrimitive(new KMLTimeStamp('','2008-05-25'));
$lugarHistoFolder->addFeature($lugarFollow);


$lugarFolder->addFeature($lugarHistoFolder);






// puertos
$portFolder = new KMLFolder('', 'Ports');


$port = new KMLPlaceMark('', 'Brest');
$port->setGeometry(new KMLPoint(-1.5, 5,0));
$port->setStyleUrl('#portStyle');
$portFolder->addFeature($port);

$port = new KMLPlaceMark('', 'Le Havre');
$port->setGeometry(new KMLPoint(5, 5,0));
$port->setStyleUrl('#portStyle');
$portFolder->addFeature($port);




// zona
$areaFolder = new KMLFolder('', 'Zones');

$mediterranee = new KMLPlaceMark('', 'Mediterranee');
$mediterranee->setGeometry (new KMLPolygon( Array (
                           array ( 2, 0,0),
                           array (-4, 0,0),
                           array (-5, 5,100),
                           array ( 1, 5,0),
                           array ( 2, 0,0)                           
                        ), true, '', true)
                     );
                     
$mediterranee->setStyleUrl('#polyStyle');

$areaFolder->addFeature($mediterranee);


$document->addFeature($portFolder);
$document->addFeature($areaFolder);

/**
  * Ajout du répertoire
  */
$kml->setFeature($documentokml);




/**
  * Output result
  */

echo '<pre>';
echo htmlspecialchars($kml->output('S'));
echo '</pre>';

echo $kml->output('S');


$kml->output('F', 'output/test.kml');
$kml->output('Z', 'output/test.kmz');

?>
