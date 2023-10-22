<?php
require_once ("clases/clase.lugar.php");

$decimales = 8;
$diferencia_max = 20; // porcentaje max de diferencia para considerarlo diferente, y meterlo

$notas="";

$path    = '/home/efimerus/Dropbox/03.ViajesY+/01.Localizaciones/02.AlpineQuest Waypoints/Exported landmarks';
$files = scandir($path);

echo "<pre>"; print_r($files);

//Checking if file is selected or not
for ($i=2; $i<count($files); $i++){

	//Now we are going to open and read the uploaded file. 
	echo "<center><span id='Content'>Contents of ".$files[$i]." File</span></center>";
	 
	//Getting and storing the temporary file name of the uploaded file
	$fileName = $files[$i];

	$xml=simplexml_load_file($path.'/'.$fileName, 'SimpleXMLElement', LIBXML_NOCDATA)or die("Error: Cannot create object");
	$array = json_decode(json_encode((array)$xml), TRUE);
	
	// echo "<pre>"; print_r($array);

	// SI TIENE WAYPOINTS, RECORRER Y METER
	$wpts = array();

	if (!empty($array['wpt'])) {
		if (empty($array['wpt']['time'])) {
			$wpts = $array['wpt'];
		} else {
			$wpts[0] = $array['wpt'];
		}
	
		// echo "<pre>"; print_r($array);
		
		for ($j=0; $j<count($wpts); $j++){

			$lugar = new lugar($usuario);
			// $lugar->nombre = preg_replace("/[^a-zA-Z0-9 ]/", "", $wpts[$j]['name']);
			$lugar->nombre = $lugar->limpiarNombre($wpts[$j]['name']);

			$lugar->notas = $notas;

			$atributos = $wpts[$j]['@attributes'];
			 
			$lon = $atributos['lon'];
			$lat = $atributos['lat'];
			$lugar->lat = round($lat, 8);
			$lugar->lon = round($lon, 8);
				
			echo "Nombre: ".$lugar->nombre."- lat: ".$lugar->lat."- lon: ".$lugar->lon."- notas: ".$lugar->notas;
				
			if (($lugar->lat != "") && ($lugar->lon != "")) {

				// echo "<pre>"; print_r($lugar);

				$result = $lugar->buscar($decimales, $diferencia_max);
				if (empty($result)) {
					$lugar->insertar();
					echo ' - padentro';
				} else {
					echo ' - Ya existe';
				}
				
			} else {
				echo "error";
			}
			echo "<br>";
			 
		}

	} 
	//header ("Location:index.php?contenido=lugares");
} ?>
