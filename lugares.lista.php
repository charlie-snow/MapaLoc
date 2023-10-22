<?php
require_once ("clases/clase.generalista.php");
$generador = new generaLista($usuario);

?>

<table border="0" cellspacing="2" cellpadding="2" align="center" width="600">
<tr>
	<td align="Center" colspan="5">
		<big>Localizaciones - 
		<a href="index.php?contenido=lugaresakml&tipo=lugares&pais=<?php echo $pais_mapa ?>">Exportar a kml</a> - 
		<a href="index.php?contenido=lugares.exportar.links&tipo=lugares&pais=<?php echo $pais_mapa ?>&usuario=<?php echo $usuario ?>">Exportar a links</a> - 
		<a href="lugares.exportar.links.bomberos.php?tipo=lugares&pais=<?php echo $pais_mapa ?>&usuario=<?php echo $usuario ?>" target=blank>Exportar a links bomberos</a></big>
	</td>
</tr>
<?php
for ($j=0; $j<count($tipos); $j++){

$resultados = $generador->generarListaLugares ('nombre', $tipos[$j]['tipo'], $pais_mapa);
if (count($resultados) != 0) {
?>

<tr>
	<td align="center" colspan="7">
	.............................
	<img src="./img/<?php echo $tipos[$j]['tipo']; ?>.png" height="20" width="20">
     
	<big><?php echo $tipos[$j]['tipo']; ?> <?php echo count($resultados); ?></big>
	.............................
	</td>
</tr>

<?php
for ($i=0; $i<count($resultados); $i++){
	$id=$resultados[$i]['id'];
	$nombre=$resultados[$i]['nombre'];
	$lat=$resultados[$i]['lat'];
	$lon=$resultados[$i]['lon'];
	$altitud=$resultados[$i]['altitud'];
	$fechahora=$resultados[$i]['fechahora'];
	$descripcion=$resultados[$i]['descripcion'];
	$tipo=$resultados[$i]['tipo'];
	$pais=$resultados[$i]['pais'];
	$ciudad=$resultados[$i]['ciudad'];
	$region=$resultados[$i]['region'];
	$direccion=$resultados[$i]['direccion'];

	$localizador = new localizador;
	// $localizador->direccionDelPunto($lon, $lat);
?>

<tr>
	<td align="left" class="fecha" 
	onmouseover="apuntar_lugar('<?php echo $id; ?>', <?php echo $lon; ?>, <?php echo $lat; ?>, '<?php echo $nombre; ?>');" 
	onmouseout="desapuntar_lugar('<?php echo $id; ?>');"
	onclick="centrar_lugar(<?php echo $lon; ?>, <?php echo $lat; ?>);"
	>
		<p>
		<img src="./img/<?php echo $tipos[$j]['tipo']; ?>.png" height="15" width="15">
		<big><?php echo $nombre; ?></big>
		</p>
	</td>
	<td>
		<?php echo substr($fechahora, 0, 10); ?>
	</td>
	<td>
		<?php echo $altitud; ?>m
	</td>
	<td>
		<a href="index.php?contenido=lugar.retirar&id=<?php echo $id; ?>">---</a>
	</td>
	<td>
		<a href="index.php?contenido=lugar.agregar&id=<?php echo $id; ?>">+++</a>
	</td>
	<td>
		<a href="index.php?contenido=lugar&id=<?php echo $id; ?>"><img src="./img/editar.png" height="15" width="15"></a>
	</td>
	<td>
		<a href="index.php?contenido=lugar.eliminar&id=<?php echo $id; ?>"><img src="./img/eliminar.png" height="15" width="15"></a>
	</td>
	<td>
		<img src="blank.gif" class="flag flag-<?php echo strtolower($pais); ?>" alt="<?php echo $pais; ?>" />
		<?php
		echo " - ";
		if ($region == "Galicia" || $region == "GA") {
			echo "<img src='blank.gif' class='flag flag-gz' alt='Galicia' />";
		} else {
			echo $region;
		}
		echo " - ";
		echo $ciudad;
		?> 
	</td>
</tr>

<?php } } } ?>

</table>