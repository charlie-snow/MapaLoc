<?php
	
$url = $_POST['texto'];

/* decodificar URL tipo: 
https://www.google.es/maps/place/Castelo+San+Felipe/@43.4138619,-8.3383165,11.26z/data=!4m13!1m7!3m6!1s0x0:0x0!2zNDPCsDE0JzQxLjMiTiA4wrAyNSc0My43Ilc!3b1!8m2!3d43.244795!4d-8.4288!3m4!1s0x0:0x3bb290d2cef3a7ec!8m2!3d43.4646511!4d-8.2816422

@:	https://www.google.es/maps/place/Castelo+San+Felipe/
	43.4138619,-8.3383165,11.26z/data=!4m13!1m7!3m6!1s0x0:0x0!2zNDPCsDE0JzQxLjMiTiA4wrAyNSc0My43Ilc!3b1!8m2!3d43.244795!4d-8.4288!3m4!1s0x0:0x3bb290d2cef3a7ec!8m2!3d43.4646511!4d-8.2816422

@[0]: https://www.google.es/maps/place/Castelo+San+Felipe/

	/:		https:/
			www.google.es
			maps
			place
			Castelo+San+Felipe

	/[5]:	Castelo+San+Felipe

@[1]: 43.4138619,-8.3383165,11.26z/data=!4m13!1m7!3m6!1s0x0:0x0!2zNDPCsDE0JzQxLjMiTiA4wrAyNSc0My43Ilc!3b1!8m2!3d43.244795!4d-8.4288!3m4!1s0x0:0x3bb290d2cef3a7ec!8m2!3d43.4646511!4d-8.2816422

	/:  	43.4138619,-8.3383165,11.26z
			data=!4m13!1m7!3m6!1s0x0:0x0!2zNDPCsDE0JzQxLjMiTiA4wrAyNSc0My43Ilc!3b1!8m2!3d43.244795!4d-8.4288!3m4!1s0x0:0x3bb290d2cef3a7ec!8m2!3d43.4646511!4d-8.2816422

	/[1]:	data=!4m13!1m7!3m6!1s0x0:0x0!2zNDPCsDE0JzQxLjMiTiA4wrAyNSc0My43Ilc!3b1!8m2!3d43.244795!4d-8.4288!3m4!1s0x0:0x3bb290d2cef3a7ec!8m2!3d43.4646511!4d-8.2816422

			!3d:  	data=!4m13!1m7!3m6!1s0x0:0x0!2zNDPCsDE0JzQxLjMiTiA4wrAyNSc0My43Ilc!3b1!8m2
					43.244795!4d-8.4288!3m4!1s0x0:0x3bb290d2cef3a7ec!8m2
					43.4646511!4d-8.2816422

			!3d[ultimo]:	43.4646511!4d-8.2816422

					!4d:	43.4646511
							-8.2816422

*/

$arroba = explode ('@', $url);

$nombreaqui = explode ('/', $arroba[0]);
$nombre = preg_replace("/[^a-zA-Z0-9 ]/", " ", $nombreaqui[5]);

$barra = explode ('/', $arroba[1]);
$tresd = explode ('!3d', $barra[1]);
$cuatrod = explode ('!4d', $tresd[sizeof($tresd)-1]);
$lat=$cuatrod[0];
$lon=$cuatrod[1];
$lat = trim($lat);
$lon = trim($lon);

$notas = "";

echo "URL: <br>".$_POST['texto']."<br><br>";
echo "<br><br>";
?>

<form action="index.php?contenido=importar.url.insertar" method="post" enctype="multipart/form-data">

	<input type="text" name="nombre" size="60" value="<?php echo $nombre ?>"/>
	<input type="hidden" name="lat" value="<?php echo $lat; ?>">
	<input type="hidden" name="lon" value="<?php echo $lon; ?>">
	<input type="submit" value="Insertar" />

</form>

<br><br>
Coordenadas: lat - <?php echo $lat; ?> lon - <?php echo $lon; ?>