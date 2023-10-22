<?php

class localizador {

// key de Map Quest
var $key = 'MtX0VjDIXIFqC5pclfuvY7P1AuEOtvlf';

var $lon;
var $lat;

var $direccion;
var $ciudad;
var $region;
var $pais;

function __construct() {

	require_once ("clases/clase.conexion.php");
	$this->conexion = new conexionMYSQL;
	$this->conexion->conectar();

}

function coodenadasDeLaDireccion($direccion) {

	$json = file_get_contents("http://open.mapquestapi.com/geocoding/v1/address?key=".$this->key."&location='".$direccion."'");
	$jsonArr = json_decode($json);

	$this->lon = $jsonArr->results[0]->locations[0]->latLng->lng;
	$this->lat = $jsonArr->results[0]->locations[0]->latLng->lat;
}

function centroidesDelPais($pais) {

	$sql = "SELECT * FROM `paises` WHERE `ISO3136` LIKE '".$pais."' LIMIT 1";
	$resultados = $this->conexion->matrizResultados($sql);

	$this->lon = $resultados[0]['LONG'];
	$this->lat = $resultados[0]['LAT'];
}

/* 
* Given longitude and latitude in North America, return the address using The Google Geocoding API V3
*
*/

function Get_Address_From_Google_Maps($lat, $lon) {

$url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$lon&sensor=false";

// Make the HTTP request
$data = @file_get_contents($url);
// Parse the json response
$jsondata = json_decode($data,true);

// If the json data is invalid, return empty array
if (!$this->check_status($jsondata))   return array();

$address = array(
    'country' => $this->google_getCountry($jsondata),
    'province' => $this->google_getProvince($jsondata),
    'city' => $this->google_getCity($jsondata),
    'street' => $this->google_getStreet($jsondata),
    'postal_code' => $this->google_getPostalCode($jsondata),
    'country_code' => $this->google_getCountryCode($jsondata),
    'formatted_address' => $this->google_getAddress($jsondata),
);

return $address;
}

/* 
* Check if the json data from Google Geo is valid 
*/

function check_status($jsondata) {
    if ($jsondata["status"] == "OK") return true;
    return false;
}

/*
* Searching in Google Geo json, return the long name given the type. 
* (If short_name is true, return short name)
*/

function Find_Long_Name_Given_Type($type, $array, $short_name = false) {
    foreach( $array as $value) {
        if (in_array($type, $value["types"])) {
            if ($short_name)    
                return $value["short_name"];
            return $value["long_name"];
        }
    }
}

/*
* Given Google Geocode json, return the value in the specified element of the array
*/

function google_getCountry($jsondata) {
    return $this->Find_Long_Name_Given_Type("country", $jsondata["results"][0]["address_components"]);
}
function google_getProvince($jsondata) {
    return $this->Find_Long_Name_Given_Type("administrative_area_level_1", $jsondata["results"][0]["address_components"], true);
}
function google_getCity($jsondata) {
    return $this->Find_Long_Name_Given_Type("locality", $jsondata["results"][0]["address_components"]);
}
function google_getStreet($jsondata) {
    return $this->Find_Long_Name_Given_Type("street_number", $jsondata["results"][0]["address_components"]) . ' ' . $this->Find_Long_Name_Given_Type("route", $jsondata["results"][0]["address_components"]);
}
function google_getPostalCode($jsondata) {
    return $this->Find_Long_Name_Given_Type("postal_code", $jsondata["results"][0]["address_components"]);
}
function google_getCountryCode($jsondata) {
    return $this->Find_Long_Name_Given_Type("country", $jsondata["results"][0]["address_components"], true);
}
function google_getAddress($jsondata) {
    return $jsondata["results"][0]["formatted_address"];
}

/*
*  Print an array
*/

function d($a) {
    echo "<pre>";
    print_r($a);
    echo "</pre>";
}

function direccionDelPunto($lon, $lat) {

	/*
	$direccion = $this->Get_Address_From_Google_Maps($lat, $lon);

	$this->d($direccion);

	$this->direccion = $direccion['formatted_address'];
	$this->ciudad = $direccion['city'];
	$this->region = $direccion['province'];
	$this->pais = $direccion['country_code'];
	*/

	$url = 'http://www.mapquestapi.com/geocoding/v1/reverse?key='.$this->key.'&callback=renderReverse&location='.$lat.','.$lon;
	$json = file_get_contents($url);
	// quitarle el encabezado chungo y los paréntesis "renderReverse( .... )"
	echo $url;
	$json = substr($json, 14, -1);

	$jsonArr = json_decode($json);

	$this->direccion = $jsonArr->results[0]->locations[0]->street;
	$this->ciudad = $jsonArr->results[0]->locations[0]->adminArea5;
	$this->region = $jsonArr->results[0]->locations[0]->adminArea3;
	$this->pais = $jsonArr->results[0]->locations[0]->adminArea1;
}

}

/*

FORMATOS:

1. direccionDelPunto: 

http://open.mapquestapi.com/geocoding/v1/address?key=MtX0VjDIXIFqC5pclfuvY7P1AuEOtvlf&location=Lancaster,PA

	{
	    "info": {
	        "statuscode": 0,
	        "copyright": {
	            "text": "\u00A9 2016 MapQuest, Inc.",
	            "imageUrl": "http://api.mqcdn.com/res/mqlogo.gif",
	            "imageAltText": "\u00A9 2016 MapQuest, Inc."
	        },
	        "messages": []
	    },
	    "options": {
	        "maxResults": -1,
	        "thumbMaps": true,
	        "ignoreLatLngInput": false
	    },
	    "results": [{
	        "providedLocation": {
	            "location": "Lancaster,PA"
	        },
	        "locations": [{
	            "street": "",
	            "adminArea6": "",
	            "adminArea6Type": "Neighborhood",
	            "adminArea5": "Lancaster",
	            "adminArea5Type": "City",
	            "adminArea4": "Lancaster County",
	            "adminArea4Type": "County",
	            "adminArea3": "PA",
	            "adminArea3Type": "State",
	            "adminArea1": "US",
	            "adminArea1Type": "Country",
	            "postalCode": "",
	            "geocodeQualityCode": "A5XAX",
	            "geocodeQuality": "CITY",
	            "dragPoint": false,
	            "sideOfStreet": "N",
	            "linkId": "0",
	            "unknownInput": "",
	            "type": "s",
	            "latLng": {
	                "lat": 40.03813,
	                "lng": -76.305669
	            },
	            "displayLatLng": {
	                "lat": 40.03813,
	                "lng": -76.305669
	            },
	            "mapUrl": "http://open.mapquestapi.com/staticmap/v4/getmap?key=MtX0VjDIXIFqC5pclfuvY7P1AuEOtvlf&type=map&size=225,160&pois=purple-1,40.03813,-76.3056686,0,0,|¢er=40.03813,-76.3056686&zoom=12&rand=1787872795"
	        }, {
	            "street": "",
	            "adminArea6": "",
	            "adminArea6Type": "Neighborhood",
	            "adminArea5": "",
	            "adminArea5Type": "City",
	            "adminArea4": "Lancaster County",
	            "adminArea4Type": "County",
	            "adminArea3": "PA",
	            "adminArea3Type": "State",
	            "adminArea1": "US",
	            "adminArea1Type": "Country",
	            "postalCode": "",
	            "geocodeQualityCode": "A4XCX",
	            "geocodeQuality": "COUNTY",
	            "dragPoint": false,
	            "sideOfStreet": "N",
	            "linkId": "0",
	            "unknownInput": "",
	            "type": "s",
	            "latLng": {
	                "lat": 40.08067,
	                "lng": -76.241128
	            },
	            "displayLatLng": {
	                "lat": 40.08067,
	                "lng": -76.241128
	            },
	            "mapUrl": "http://open.mapquestapi.com/staticmap/v4/getmap?key=MtX0VjDIXIFqC5pclfuvY7P1AuEOtvlf&type=map&size=225,160&pois=purple-2,40.08067,-76.2411283,0,0,|¢er=40.08067,-76.2411283&zoom=9&rand=255675537"
	        }, {
	            "street": "",
	            "adminArea6": "",
	            "adminArea6Type": "Neighborhood",
	            "adminArea5": "Lancaster",
	            "adminArea5Type": "City",
	            "adminArea4": "Lancaster County",
	            "adminArea4Type": "County",
	            "adminArea3": "PA",
	            "adminArea3Type": "State",
	            "adminArea1": "US",
	            "adminArea1Type": "Country",
	            "postalCode": "",
	            "geocodeQualityCode": "A5XAX",
	            "geocodeQuality": "CITY",
	            "dragPoint": false,
	            "sideOfStreet": "N",
	            "linkId": "0",
	            "unknownInput": "",
	            "type": "s",
	            "latLng": {
	                "lat": 40.03813,
	                "lng": -76.305669
	            },
	            "displayLatLng": {
	                "lat": 40.03813,
	                "lng": -76.305669
	            },
	            "mapUrl": "http://open.mapquestapi.com/staticmap/v4/getmap?key=MtX0VjDIXIFqC5pclfuvY7P1AuEOtvlf&type=map&size=225,160&pois=purple-3,40.03813,-76.3056686,0,0,|¢er=40.03813,-76.3056686&zoom=12&rand=-1071193290"
	        }, {
	            "street": "53 McGovern Avenue",
	            "adminArea6": "",
	            "adminArea6Type": "Neighborhood",
	            "adminArea5": "Lancaster",
	            "adminArea5Type": "City",
	            "adminArea4": "Lancaster County",
	            "adminArea4Type": "County",
	            "adminArea3": "PA",
	            "adminArea3Type": "State",
	            "adminArea1": "US",
	            "adminArea1Type": "Country",
	            "postalCode": "17603",
	            "geocodeQualityCode": "P1XAX",
	            "geocodeQuality": "POINT",
	            "dragPoint": false,
	            "sideOfStreet": "N",
	            "linkId": "0",
	            "unknownInput": "",
	            "type": "s",
	            "latLng": {
	                "lat": 40.054845,
	                "lng": -76.307632
	            },
	            "displayLatLng": {
	                "lat": 40.054845,
	                "lng": -76.307632
	            },
	            "mapUrl": "http://open.mapquestapi.com/staticmap/v4/getmap?key=MtX0VjDIXIFqC5pclfuvY7P1AuEOtvlf&type=map&size=225,160&pois=purple-4,40.054845,-76.307632,0,0,|¢er=40.054845,-76.307632&zoom=15&rand=1219850803"
	        }, {
	            "street": "422 Rue Saint-Honor\u00E9",
	            "adminArea6": "Vend\u00F4me",
	            "adminArea6Type": "Neighborhood",
	            "adminArea5": "Paris",
	            "adminArea5Type": "City",
	            "adminArea4": "Paris",
	            "adminArea4Type": "County",
	            "adminArea3": "Ile-de-France",
	            "adminArea3Type": "State",
	            "adminArea1": "FR",
	            "adminArea1Type": "Country",
	            "postalCode": "75001",
	            "geocodeQualityCode": "P1XXX",
	            "geocodeQuality": "POINT",
	            "dragPoint": false,
	            "sideOfStreet": "N",
	            "linkId": "0",
	            "unknownInput": "",
	            "type": "s",
	            "latLng": {
	                "lat": 48.868331,
	                "lng": 2.323771
	            },
	            "displayLatLng": {
	                "lat": 48.868331,
	                "lng": 2.323771
	            },
	            "mapUrl": "http://open.mapquestapi.com/staticmap/v4/getmap?key=MtX0VjDIXIFqC5pclfuvY7P1AuEOtvlf&type=map&size=225,160&pois=purple-5,48.8683313,2.3237711,0,0,|¢er=48.8683313,2.3237711&zoom=15&rand=1368054527"
	        }]
	    }]
	}

2. coodenadasDeLaDireccion:

http://www.mapquestapi.com/geocoding/v1/reverse?key=MtX0VjDIXIFqC5pclfuvY7P1AuEOtvlf&callback=renderReverse&location=40.053116,-8

	renderReverse({
	    "info": {
	        "statuscode": 0,
	        "copyright": {
	            "text": "\u00A9 2016 MapQuest, Inc.",
	            "imageUrl": "http://api.mqcdn.com/res/mqlogo.gif",
	            "imageAltText": "\u00A9 2016 MapQuest, Inc."
	        },
	        "messages": []
	    },
	    "options": {
	        "maxResults": 1,
	        "thumbMaps": true,
	        "ignoreLatLngInput": false
	    },
	    "results": [{
	        "providedLocation": {
	            "latLng": {
	                "lat": 40.053116,
	                "lng": -76.313603
	            }
	        },
	        "locations": [{
	            "street": "1101 N Charlotte St",
	            "adminArea6": "",
	            "adminArea6Type": "Neighborhood",
	            "adminArea5": "Lancaster",
	            "adminArea5Type": "City",
	            "adminArea4": "Lancaster",
	            "adminArea4Type": "County",
	            "adminArea3": "PA",
	            "adminArea3Type": "State",
	            "adminArea1": "US",
	            "adminArea1Type": "Country",
	            "postalCode": "17603",
	            "geocodeQualityCode": "P1AAA",
	            "geocodeQuality": "POINT",
	            "dragPoint": false,
	            "sideOfStreet": "R",
	            "linkId": "0",
	            "unknownInput": "",
	            "type": "s",
	            "latLng": {
	                "lat": 40.053356,
	                "lng": -76.313641
	            },
	            "displayLatLng": {
	                "lat": 40.053356,
	                "lng": -76.313641
	            },
	            "mapUrl": "http://www.mapquestapi.com/staticmap/v4/getmap?key=MtX0VjDIXIFqC5pclfuvY7P1AuEOtvlf&type=map&size=225,160&pois=purple-1,40.053356,-76.313641,0,0,|¢er=40.053356,-76.313641&zoom=15&rand=1606535298"
	        }]
	    }]
	})


*/

?>
