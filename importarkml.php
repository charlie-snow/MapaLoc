 <p><big>KML</big></p>

<form action="" method="post" enctype="multipart/form-data">
<input type="file" name="file" size="60" />
tipo: <input type="text" name="tipo" size="20" />
<input type="submit" value="Read Content" />
</form>

<?php
require_once ("clases/clase.lugar.php");

$tipo = $_POST['tipo'];

$decimales = 6;
$diferencia_max = 20; // porcentaje max de diferencia para considerarlo diferente, y meterlo

$notas="";
//Checking if file is selected or not
if($_FILES['file']['name'] != "") {

	//Now we are going to open and read the uploaded file. 
	echo "<center><span id='Content'>Contents of ".$_FILES['file']['name']." File</span></center>";
	 
	//Getting and storing the temporary file name of the uploaded file
	$fileName = $_FILES['file']['tmp_name'];

	$xml=simplexml_load_file($fileName, 'SimpleXMLElement', LIBXML_NOCDATA)or die("Error: Cannot create object");
	$array = json_decode(json_encode((array)$xml), TRUE);
	
	// echo "<pre>"; print_r($array['Document']);
	
	if ($array['Document']['Folder'] != null) {
		$Folders = $array['Document']['Folder'];
		// echo "<pre>"; print_r($Folders);

		if ($Folders[0] == null) { // si sólo hay un folder
			
			$Folders[0] = $Folders;
			// echo $Folders['name'];
			// echo $Folders['Placemark']['name'];
			/*
			$nombre = preg_replace("/[^a-zA-Z0-9 ]/", "", $Folders['Placemark']['name']);
			$lon = explode(',', $Folders['Placemark']['Point']['coordinates'])[0];
			$lat = explode(',', $Folders['Placemark']['Point']['coordinates'])[1];
			
			echo "-".$nombre."- tipo: ".$tipo."- lat: ".$lat."- lon: ".$lon."- notas: ".$notas;
			
				if (($lat != "") && ($lon != "")) {
				
					$lugar = new lugar($usuario);
					$result = $lugar->buscar($lat, $lon);
					if (empty($result)) {
						$lugar->insertar($nombre, $tipo, $lat, $lon, $notas);
						echo 'padentro';
					} else {
						echo 'Ya existe';
					}
					
				} else {
					echo "error";
				}
				echo "<br>";
			*/
			
		} 

			// echo "<pre>"; print_r($Folders);
			// echo count($Folders);

		 for ($i=0; $i<count($Folders); $i++){
			 // $res = preg_replace("/[^a-zA-Z0-9 ]/", "", $Folders[$i]['name']);
			 // $tipo = $res;
			 //$tipo = (string)$Folders[$i]['name'];
			 $Placemarks = $Folders[$i]['Placemark'];

			 // echo "<pre>"; print_r($Placemarks);

			for ($j=0; $j<count($Placemarks); $j++){
				$nombre = preg_replace("/[^a-zA-Z0-9 ]/", "", $Placemarks[$j]['name']);

		 		$id = $nombre;

				//$nombre = (string)$Placemarks[$j]['name'];
				$lon = explode(',', $Placemarks[$j]['Point']['coordinates'])[0];
				$lat = explode(',', $Placemarks[$j]['Point']['coordinates'])[1];
				$lat = round($lat, 8);
				$lon = round($lon, 8);
				
				echo "Nombre: ".$nombre."- tipo: ".$tipo."- lat: ".$lat."- lon: ".$lon."- notas: ".$notas;
				
					if (($lat != "") && ($lon != "")) {
					
						$lugar = new lugar($usuario);
						$result = $lugar->buscar($nombre, $lat, $lon, $decimales);
						if (empty($result)) {
							$lugar->insertar($nombre, $tipo, $lat, $lon, $notas);
							echo 'padentro';
						} else {
							echo 'Ya existe';
						}
						
					} else {
						echo "error";
					}
					echo "<br>";
			 
		  }
	}
	} else {
		
		$Placemarks = $array['Document']['Placemark'];
		// echo "<pre>"; print_r($Placemarks);
		
		for ($j=0; $j<count($Placemarks); $j++){
			
			echo "<br>";
			
				$nombre = preg_replace("/[^a-zA-Z0-9 ]/", "", $Placemarks[$j]['name']);
				
		 		$id = $nombre;

				//$nombre = (string)$Placemarks[$j]['name'];
				$lon = explode(',', $Placemarks[$j]['Point']['coordinates'])[0];
				$lat = explode(',', $Placemarks[$j]['Point']['coordinates'])[1];
				$lat = round($lat, 8);
				$lon = round($lon, 8);
				
				echo "Nombre: ".$nombre."- tipo: ".$tipo."- lat: ".$lat."- lon: ".$lon."- notas: ".$notas;
				$lugar = new lugar($usuario);
				$result = $lugar->buscar($nombre, $lat, $lon, $decimales);
				if (empty($result)) {
					$lugar->insertar($nombre, $tipo, $lat, $lon, $notas);
					echo 'padentro';
				} else {
					echo 'Ya existe';
				}
				echo "<br>";
			}
		}
		
	
	
	// echo "<pre>"; print_r($array['Document']);
	

	//header ("Location:index.php?contenido=lugares");
} ?>
