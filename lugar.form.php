<?php // if ($_SESSION['usuario_nivel'] == 1) { } ?>

<form action="lugar.modificar.php" method="post" name="lugar" id="lugar">
 
<input type="hidden" name="id" value="<?php echo $lugar->id ?>" id="id">

<table width="90%" align="center">

<tr>
	<td colspan="<?php echo(count($lugar->campos)) ?>" class="td_azul_oscuro">Lugar - id.<?php echo $lugar->id ?>
		<input type = "submit" value = " Insertar / Modificar "/>

	</td>
</tr>
<tr>
<?php for ($j=1; $j<=count($lugar->campos)-1; $j++) { 
	$nombre_campo = $lugar->campos[$j];
	if ($nombre_campo != 'neto_iva') { 			// el campo neto_iva se genera de neto ?>
	<td class="td_azulin" align="center"><?php echo($lugar->campos[$j]) ?></td>
<?php } } ?>
</tr>
<tr>
<?php for ($j=1; $j<=count($lugar->campos)-1; $j++) { 
	$nombre_campo = $lugar->campos[$j];
	if ($nombre_campo != 'neto_iva') { 			// el campo neto_iva se genera de neto ?>
	<td>
	<textarea rows="3" cols="10" wrap="physical" name="<?php echo($lugar->campos[$j]) ?>" id="<?php echo($nombre_campo) ?>"><?php echo $lugar->$nombre_campo; ?></textarea>
	</td>
<?php } } ?>
</tr>
</table>

</form>

<script src="http://maps.googleapis.com/maps/api/js"></script>

	<script>
	var punto = new google.maps.LatLng(<?php echo $lugar->lat.",".$lugar->lon; ?>);
		
	function initialize() {
	  var mapProp = {
		center:new google.maps.LatLng(<?php echo $lugar->lat.",".$lugar->lon; ?>),
		zoom:15,
		mapTypeId:google.maps.MapTypeId.ROADMAP
	  };
	  var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);
	  
	  var marker = new google.maps.Marker({
		  position: punto, // marker coordinates
		  map: map,
		  title:"<?php echo $lugar->nombre; ?>"
	  });
	}
	google.maps.event.addDomListener(window, 'load', initialize);
	</script>
	<div id="googleMap" style="width:300px;height:300px;"></div>