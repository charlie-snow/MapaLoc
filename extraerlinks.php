<p><big>hmtl - solo funciona con el archivo en el raiz. extrae links y los devuelve separados por comas </big></p>
<form action="" method="post" enctype="multipart/form-data">
<input type="file" name="file" size="60" />
tipo: <input type="text" name="tipo" size="20" />
<input type="submit" value="Read Content" />
</form>

<?php
require_once ("clases/clase.lugar.php");

$tipo = $_POST['tipo'];

$decimales = 8;
$diferencia_max = 20; // porcentaje max de diferencia para considerarlo diferente, y meterlo

$notas="";

//Checking if file is selected or not
if($_FILES['file']['name'] != "") {

	$Filepath = $_FILES['file']['name'];

	//Now we are going to open and read the uploaded file. 
	echo "<center><span id='Content'>Contents of ".$Filepath." File</span></center>";
	 
	//Getting and storing the temporary file name of the uploaded file

	// echo '<pre>'; print_r($_FILES['file']);

	try
	{

	  $url = $Filepath;
	  $input = @file_get_contents($url) or die("Could not access file: $url");
	  $regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a>";
	  if(preg_match_all("/$regexp/siU", $input, $matches)) {
	    // echo "<pre>matches: "; print_r($matches);
	  }

		$links = $matches[2];

		// echo "<pre>links: "; print_r($links);

		for ($i=0; $i<count($links); $i++){ // diferencia: comienza en el registro 2

			$coordenadas = explode(",",explode("=", $links[$i])[1]);

			$lat = $coordenadas[0];
			$lon = $coordenadas[1];
			
			$lat = round($lat, 8);
			$lon = round($lon, 8);
				
			echo $lat.", ".$lon."<br>";
			 
		  }		

		//header ("Location:index.php?contenido=lugares");
		
	}
	catch (Exception $E)
	{
		echo $E -> getMessage();
	}

} ?>
