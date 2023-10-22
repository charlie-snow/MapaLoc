<?php

// $json = file_get_contents('http://open.mapquestapi.com/geocoding/v1/address?key=MtX0VjDIXIFqC5pclfuvY7P1AuEOtvlf&location=Lancaster,PA');
// $jsonArr = json_decode($json);

// $lon1 = $jsonArr->results[0]->locations[0]->latLng->lng;
// $lat1 = $jsonArr->results[0]->locations[0]->latLng->lat;


$json = file_get_contents('http://www.mapquestapi.com/geocoding/v1/reverse?key=MtX0VjDIXIFqC5pclfuvY7P1AuEOtvlf&callback=renderReverse&location=40.053116,-8');
	// quitarle un encabezado chungo
	$json = substr($json, 14, -1);

$jsonArr = json_decode($json);

// $lon1 = $jsonArr->results[0]->locations[0]->latLng->lng;
// $lat1 = $jsonArr->results[0]->locations[0]->latLng->lat;

$direccion = $jsonArr->results[0]->locations[0]->adminArea1;

echo $direccion;
echo '<pre>';
print_r ($jsonArr->results[0]->locations[0]);
echo '<pre>';

?> 