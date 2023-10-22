<?php
include "estilos-links.php";

require_once ("clases/clase.generalista.php");

$usuario = $_SESSION['usuario_id'];
if (isset ($_GET['usuario'])) {
	$usuario = $_GET['usuario'];
}

if(isset($_GET['tipo'])){ $tipo = $_GET['tipo']; }
if(isset($_GET['pais'])){ $pais = $_GET['pais']; }

$generador = new generaLista;

$resultados = $generador->generarListaLugares ('ciudad', $tipo, $pais);

?>
<table border="0" cellspacing="1" cellpadding="1" align="center" width="700">
<tr>
	<td align="Center">N</td>
	<td align="Center">Tipo</td>
	<td align="Center">Lugar</td>
	<td align="Center" width=150>region</td>
	<td align="Center" width=150>ciudad</td>
</tr>
<tr>
<?php

for ($i=0/*count($resultados)-5*/; $i<count($resultados); $i++){
	// $res = preg_replace("/[^a-zA-Z0-9]/", "", $resultados[$i]['id']);
	// $id=$res;
	
	// $res = preg_replace("/[^a-zA-Z0-9\s]/", "", $resultados[$i]['nombre']);
	// $nombre=$res;

	$id=$resultados[$i]['id'];
	$nombre=$resultados[$i]['nombre'];	
	$tipo=$resultados[$i]['tipo'];
	$lat=$resultados[$i]['lat'];
	$lon=$resultados[$i]['lon'];
	$region=$resultados[$i]['region'];
	$ciudad=$resultados[$i]['ciudad'];
	
	$res = preg_replace("/[^a-zA-Z0-9\s]/", "", $resultados[$i]['notas']);
	$notas=$res;
?>
	<td align="Center"></td>
	<td align="Center"><?php echo $tipo ?></td>
	<td align="Left"><?php echo "<a href=\"http://maps.google.com/maps?q=".$lat.",".$lon."\">".$nombre."</a>"; ?></td>
	<td align="Center"><?php echo $region ?></td>
	<td align="Center"><?php echo $ciudad ?></td>
</tr>
<?php } ?>
</table>
