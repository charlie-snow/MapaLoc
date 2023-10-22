<?php
require_once ("clases/clase.lugar.php");
$lugar = new lugar($usuario); ?>

<table border="0" cellspacing="5" cellpadding="7" align="center" width="900">
<tr>

<?php if (isset($_GET["id"])) {						// MODIFICAR
	$lugar->recuperar($_GET["id"]);
	$_SESSION['debug'] .= " Lugar recuperar: ".$lugar->sql;
?>
	<td align="left" valign="top">
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
	</td>
<?php } ?>
	<td><?php include "lugar.form.php" ?></td>
</tr>
</table>
