<?php 
require_once ("clases/clase.generalista.php");
$generador = new generaLista;

$generador->recopilarDatos();
$tipos = $generador->tipos;
$paises = $generador->paises;
$lugares = $generador->lugares;
?>