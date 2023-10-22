<?php
require_once ("clases/clase.lugar.php");

//Checking if file is selected or not
if($_FILES['file']['name'] != "") {

	//Now we are going to open and read the uploaded file. 
	echo "<center><span id='Content'>Contents of ".$_FILES['file']['name']." File</span></center>";
	 
	//Getting and storing the temporary file name of the uploaded file
	$fileName = $_FILES['file']['tmp_name'];

	$xml=simplexml_load_file($fileName, 'SimpleXMLElement', LIBXML_NOCDATA)or die("Error: Cannot create object");
	$array = json_decode(json_encode((array)$xml), TRUE);
	
	if ($array['Document']['Folder'] != null) {
		$Folders = $array['Document']['Folder'];
		
		 for ($i=0; $i<count($Folders); $i++){
			 $res = preg_replace("/[^a-zA-Z0-9 ]/", "", $Folders[$i]['name']);
			 $tipo = $res;
			 //$tipo = (string)$Folders[$i]['name'];
			 $Placemarks = $Folders[$i]['Placemark'];
			 
			for ($j=0; $j<count($Placemarks); $j++){
				$res = preg_replace("/[^a-zA-Z0-9 ]/", "", $Placemarks[$j]['name']);
				$nombre = $res;
				//$nombre = (string)$Placemarks[$j]['name'];
				$lon = explode(',', $Placemarks[$j]['Point']['coordinates'])[0];
				$lat = explode(',', $Placemarks[$j]['Point']['coordinates'])[1];
				
				echo "-".$nombre."-".$tipo."-".$lat."-".$lon."-".$notas;
				$lugar = new lugar($usuario);
				$result = $lugar->buscar($lat, $lon);
				if (empty($result)) {
					$lugar->insertar($nombre, $tipo, $lat, $lon, $notas);
					echo 'padentro';
				} else {
					echo 'Ya existe';
				}
				echo "<br>";
			}
		}
	}
	
	
	// echo "<pre>"; print_r($array['Document']);
	

	//header ("Location:index.php?contenido=lugares");
} ?>
