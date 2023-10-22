<p><big>Clasificar cambiando la primera palabra</big></p>

<?php 
require_once ("clases/clase.generalista.php");
$generador = new generaLista;

$_SESSION['volver'] = "index.php?contenido=admin.clasificar.manual";

?>

<link rel="STYLESHEET" type="text/css" href="scripts/flags/flags.css">

<table border="0" cellspacing="10" cellpadding="10" align="center">

<?php
$resultados = $generador->generarListaLugaresNoClasificados (1, true, 'lugares', '');

for ($i=0; $i<count($resultados); $i++){
	$id=$resultados[$i]['id'];
	$nombre=$resultados[$i]['nombre'];
	$tipo=$resultados[$i]['tipo'];
	$lat=$resultados[$i]['lat'];
	$lon=$resultados[$i]['lon'];
	$notas=$resultados[$i]['notas'];
	$pais=$resultados[$i]['pais'];
	$region=$resultados[$i]['region'];
	$ciudad=$resultados[$i]['ciudad'];
	$direccion=$resultados[$i]['direccion'];
?>

<form action="lugar.modificar.php" method="post" enctype="multipart/form-data">
<tr>
	<td>
		<script src="http://maps.googleapis.com/maps/api/js"></script>

		<script>
		var punto = new google.maps.LatLng(<?php echo $lat.",".$lon; ?>);
			
		function initialize() {
		  var mapProp = {
			center:new google.maps.LatLng(<?php echo $lat.",".$lon; ?>),
			zoom:15,
			mapTypeId:google.maps.MapTypeId.ROADMAP
		  };
		  var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);
		  
		  var marker = new google.maps.Marker({
			  position: punto, // marker coordinates
			  map: map,
			  title:"<?php echo $nombre; ?>"
		  });
		}
		google.maps.event.addDomListener(window, 'load', initialize);
		</script>
		<div id="googleMap" style="width:300px;height:300px;"></div>
	</td>
	<td align="left" class="fecha">
	<?php echo $tipo; ?> - <img src="./img/<?php echo $tipo; ?>.png" height="15" width="15">
	<p><big>
	<input type="text" name="nombre" value="<?php echo $nombre; ?>"> - <?php echo $lat.",".$lon; ?>
	</big>
	</p>
	<br><br>
		<img src="blank.gif" class="flag flag-<?php echo $pais; ?>" alt="<?php echo $pais; ?>" />
	</td>
	<td>
		<input type="hidden" name="id" value="<?php echo $id; ?>">
		<input type="hidden" name="tipo" value="<?php echo $tipo; ?>">
		<input type="hidden" name="lat" value="<?php echo $lat; ?>">
		<input type="hidden" name="lon" value="<?php echo $lon; ?>">
		<input type="hidden" name="pais" value="<?php echo $pais; ?>">
		<input type="hidden" name="region" value="<?php echo $region; ?>">
		<input type="hidden" name="ciudad" value="<?php echo $ciudad; ?>">
		<input type="hidden" name="direccion" value="<?php echo $direccion; ?>">
		<input type="submit" id="modificar" value="modificar" />
	</td>
</tr>
</form>

<form action="lugar.eliminar.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="id" value="<?php echo $id; ?>">
		<input type="submit" value="eliminar" />
	</form>
<?php } ?>

</table>

<script>  document.getElementById("modificar").focus(); </script>