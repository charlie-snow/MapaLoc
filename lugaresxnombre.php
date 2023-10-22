<?php

session_start();
require_once ("clases/clase.generalista.php");
$generador = new generaLista;
$resultados = $generador->generarListaLugares ($_SESSION['usuario_id'], true, 'lugares', '');
?>

<?php include "estilos-links.php"; ?>
<table border="0" cellspacing="0" cellpadding="0" align="center">

<?php
for ($i=0/*count($resultados)-5*/; $i<count($resultados); $i++){
	$id=$resultados[$i][0];
	$nombre=$resultados[$i][1];
	$lat=$resultados[$i][2];
	$lon=$resultados[$i][3];
?>

<tr>
	<td align="left" class="fecha">
	<?php
	echo $id=$resultados[$i][0];
	echo " - ";
	echo $nombre=$resultados[$i][1];
	echo " - ";
	echo $lat=$resultados[$i][2];
	echo " - ";
	echo $lon=$resultados[$i][3];
	?>
	_________________________________________________________________________________________________________________
	</td>
</tr>

<?php } ?>

</table>
