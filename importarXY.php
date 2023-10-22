<script src="scripts/conversorutmToLatLng.js"></script>

<p><big>ODS/CSV - formato de coordenadas: X/Y (zona 29) - INSERTA EN TABLA DE BOMBEROS<br><br>

Columnas: Concello Parroquia X Y

<br><br> - solo funciona con el archivo en el raiz. la primera fila es de nombres de columnas</big></p>
<form action="" method="post" enctype="multipart/form-data">
<input type="file" name="file" size="60" />
tipo: <input type="text" name="tipo" size="20" />
<input type="submit" value="Read Content" />
</form>

<?php
require_once ("clases/clase.lugar.php");
require_once("00.modulos/odsr/SpreadsheetReader.php");

$tabla = "lugares_bom";

$tipo = "parroquia";

$decimales = 8;
$diferencia_max = 20; // porcentaje max de diferencia para considerarlo diferente, y meterlo

$notas="";

$zona = 29; # (UTM de galicia)

//Checking if file is selected or not
if($_FILES['file']['name'] != "") {

	//Now we are going to open and read the uploaded file. 
	echo "<center><span id='Content'>Contents of ".$_FILES['file']['name']." File</span></center>";
	 
	//Getting and storing the temporary file name of the uploaded file
	$Filepath = $_FILES['file']['name'];

	// echo '<pre>'; print_r($_FILES['file']);

	try
	{
		$pois = array();

		$Spreadsheet = new SpreadsheetReader($Filepath);

		$Sheets = $Spreadsheet -> Sheets();		

		$Spreadsheet -> ChangeSheet(0); // solo la primera

		foreach ($Spreadsheet as $Key => $Row)
		{
			if ($Row)
			{
				// echo '<pre>'; print_r($Row);
				array_push($pois, $Row);
			}
		}

		echo "<pre>pois: "; print_r($pois);

		for ($i=1; $i<count($pois); $i++){ // diferencia: comienza en el registro 2

			$ciudad = $pois[$i][0];
			$nombre = $pois[$i][1];
			$lat = $pois[$i][3];
			$lon = $pois[$i][2];

			$lugar = new lugar($usuario);

			$lugar->ciudad = $ciudad;
			$lugar->nombre = $nombre;
			
			if ($tipo == "") {
				$lugar->tipo_from_nombre(); 
			} else {
				$lugar->tipo = $tipo;
			}

			$lugar->lat = $lat;
			$lugar->lon = $lon;
			
			$latlon = $lugar->conversorToLL($lat, $lon, $zona);

			$lugar->lat = $latlon[0];
			$lugar->lon = $latlon[1];
				
			echo "Nombre: ".$lugar->nombre."- tipo: ".$lugar->tipo."- lat: ".$lugar->lat."- lon: ".$lugar->lon."- notas: ".$lugar->notas;
				
			if (($lugar->lat != "") && ($lugar->lon != "")) {

				echo "<pre>"; print_r($lugar);

				$result = $lugar->buscar($decimales, $diferencia_max);
				if (empty($result)) {
					$lugar->insertar($tabla);
					echo 'padentro';
				} else {
					echo 'Ya existe';
				}
				
			} else {
				echo "error";
			}
			echo "<br>";
			 
		  }		
		
		//header ("Location:index.php?contenido=lugares");
		
	}
	catch (Exception $E)
	{
		echo $E -> getMessage();
	}

} ?>
