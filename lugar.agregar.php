<?php
require_once ("clases/clase.lugar.php");
$lugar = new lugar($usuario);

// echo  "test: <PRE>";echo print_r($lugar);echo "</PRE>";

$lugar->agregarAUsuario ($_GET['id'], $_SESSION['usuario_id']);
$_SESSION['debug'] .= " Lugar agregar: ".$lugar->sql;

$volver = "index.php?contenido=lugares&mapa=1&tipo=lugares";
if (isset($_SESSION['volver'])) {
 	$volver = $_SESSION['volver'];
    $_SESSION['volver'] = "";
}
header ("Location:".$volver);
?>
