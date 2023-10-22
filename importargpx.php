 <p><big>GPX</big></p>
<form action="" method="post" enctype="multipart/form-data">
<input type="file" name="file" size="60" />
<input type="submit" value="Importar puntos del GPX" />
</form>

<?php
require_once ("clases/clase.lugar.php");

// PARÁMETROS DE COMPARACIÓN, PARA NO METER REPETIDOS _________________________________
// ASÍ SÓLO DETECTA LOS QUE SON PRÁCTICAMENTE IGUALES

$decimales = 6;
$diferencia_max = 0; // porcentaje max de diferencia para considerarlo diferente, y meterlo

$notas="";
//Checking if file is selected or not
if(!empty($_FILES['file']['name']) && $_FILES['file']['name'] != "") {

	//Now we are going to open and read the uploaded file. 
	echo "<center><span id='Content'>Contents of ".$_FILES['file']['name']." File</span></center>";
	 
	//Getting and storing the temporary file name of the uploaded file
	$fileName = $_FILES['file']['tmp_name'];

	$xml=simplexml_load_file($fileName, 'SimpleXMLElement', LIBXML_NOCDATA)or die("Error: Cannot create object");
	$array = json_decode(json_encode((array)$xml), TRUE);
	
	// echo "<pre>"; print_r($array);

	$wpts = array();

	if (empty($array['time'])) {
		$wpts = $array['wpt'];
	} else {
		$wpts[0] = $array;
	}

		// echo "<pre>"; print_r($array);

	
	for ($i=0; $i<count($wpts); $i++){

		$lugar = new lugar($usuario);
		// $lugar->nombre = preg_replace("/[^a-zA-Z0-9 ]/", "", $wpts[$i]['name']);
		$lugar->nombre = $wpts[$i]['name'];

		// $lugar->tipo_from_nombre();

		$lugar->notas = $notas;

		$atributos = $wpts[$i]['@attributes'];
		 
		$lon = $atributos['lon'];
		$lat = $atributos['lat'];
		$lugar->lat = round($lat, 8);
		$lugar->lon = round($lon, 8);

		if (empty($wpts[$i]['ele'])) {
			$lugar->altitud = -99;
		} else {
			$lugar->altitud = round($wpts[$i]['ele'], 0);
		}

		if (empty($wpts[$i]['time'])) {
			$lugar->fechahora = '2000-01-01 00:00:00';
		} else {
			$lugar->fechahora = substr($wpts[$i]['time'], 0, 10)." ".substr($wpts[$i]['time'], 11, 8);
		}

		if (empty($wpts[$i]['desc'])) {
			$lugar->descripcion = null;
		} else {
			$lugar->descripcion = $wpts[$i]['desc'];
		}
			
		echo "<br>Nombre: ".$lugar->nombre."- tipo: ".$lugar->tipo."- lat: ".$lugar->lat."- lon: ".$lugar->lon."- fechahora: ".$lugar->fechahora."- descripcion: ".$lugar->descripcion."- altitud: ".$lugar->altitud;
			
		if (($lugar->lat != "") && ($lugar->lon != "")) {

			// echo "<pre>"; print_r($lugar);

			$result = $lugar->buscar($decimales, $diferencia_max);
			if (empty($result)) {
				$lugar->insertar();
				echo $lugar->nombre.' padentro <br>';
			} else {
				echo 'Ya existe <br>';
			}
			
		} else {
			echo "error";
		}
		echo "<br>";
		 
	  }
	
	//header ("Location:index.php?contenido=lugares");
} ?>
