<html>
<head>
<title>Local</title>
<script src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" >

function getDireccion(){

// alert(document.getElementById('formulario').lat.name);

lat = document.getElementById('formulario').lat.value;
lon = document.getElementById('formulario').lon.value;

var geocoder = new google.maps.Geocoder();
var yourLocation = new google.maps.LatLng(lat, lon);
geocoder.geocode({ 'latLng': yourLocation },processGeocoder);


}


function processGeocoder(results, status){

if (status == google.maps.GeocoderStatus.OK) {
if (results[0]) {
	// document.forms[0].dir.value=results[0].formatted_address;
	alert (results[0].formatted_address);
} else {
error('Google no retorno resultado alguno.');
}
} else {
error("Geocoding fallo debido a : " + status);
}

}
function error(msg) {
alert(msg);
}

</script>
</head>
<body>
<h1>Informaci&oacute;n de Geolocalizaci&oacute;n</h1>
<form id="formulario">
<input type="button" onclick="getDireccion()" value="Obtener Direccion"/>
Longitud: <input type="text" name="lon" width="150"/>
Latitud: <input type="text" name="lat" width="150"/>
</form>
</body>
</html>