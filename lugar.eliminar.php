<?php
require_once ("clases/clase.lugar.php");
$lugar = new lugar($usuario);
$lugar->eliminar ($_GET['id']);

$volver = "index.php?contenido=lugares&mapa=1&tipo=lugares";
if (isset($_SESSION['volver'])) {
 	$volver = $_SESSION['volver'];
    $_SESSION['volver'] = "";
}
header ("Location:".$volver);
?>
