<?php
$volver = "index.php?contenido=lugar&id=";

require_once ("clases/clase.lugar.php");
$lugar = new lugar($usuario);

$decimales = 6;
$diferencia_max = 20; // porcentaje max de diferencia para considerarlo diferente, y meterlo

$id = 0;

$lugar->nombre = $_POST['nombre'];
$lugar->lat = $_POST['lat'];
$lugar->lon = $_POST['lon'];

if (($lugar->lat != "") && ($lugar->lon != "")) {
	$result = $lugar->buscar($decimales, $diferencia_max);
	if (empty($result)) {
		$lugar->localizar();
		$id = $lugar->insertar();
		echo 'padentro';		
	} else {
		$id = $result[0]['id'];
		echo 'Ya existe. No introducido';
	}
	
} else {
	echo "error";
}
echo "<br>";

// formato: https://www.google.es/maps/place/Castelo+San+Felipe/@43.4602139,-8.2797299,14.51z/data=!4m13!1m7!3m6!1s0x0:0x0!2zNDPCsDE0JzQxLjMiTiA4wrAyNSc0My43Ilc!3b1!8m2!3d43.244795!4d-8.4288!3m4!1s0x0:0x3bb290d2cef3a7ec!8m2!3d43.4646511!4d-8.2816422
?>

<a href="<?php echo $volver.$id; ?>">Ver lugar</a> 