<?php
session_start();
require_once ("clases/clase.lugar.php");
$lugar = new lugar($usuario);

for ($j=0; $j<=count($lugar->campos)-1; $j++) {
	$nombre_campo = $lugar->campos[$j];
	$valor = $_POST[$nombre_campo];
	$lugar->$nombre_campo = $valor;
}

echo  "test: <PRE>";echo print_r($lugar);echo "</PRE>";

$lugar->modificar ($_POST['id']);
$_SESSION['debug'] .= " Lugar modificar: ".$lugar->sql;

$volver = "index.php?contenido=lugares&mapa=1&tipo=lugares";
if (isset($_SESSION['volver'])) {
 	$volver = $_SESSION['volver'];
    $_SESSION['volver'] = "";
}
header ("Location:".$volver);
?>
