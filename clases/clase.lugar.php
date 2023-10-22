<?php

class lugar {

var $campos = array();

var $sql = '';

function __construct($usuario = null) {

	$this->usuario = $_SESSION['usuario_id'];
	$this->tabla = $_SESSION['tabla'];
	$this->modoprueba = $_SESSION['modoprueba'];

	require_once ("clases/clase.conexion.php");
	$this->conexion = new conexionMYSQL;
	$this->conexion->conectar();

	$sql = "SELECT * FROM ".$this->tabla;
	$this->conexion->ejecutar($sql);

	$info_campo = $this->conexion->consulta->fetch_fields();

    foreach ($info_campo as $valor) {
    	$nombre_campo = (string)$valor->name;
    	$this->$nombre_campo = "";
        array_push($this->campos, $nombre_campo);
    }

}

function recuperar($id){

	$sql = "SELECT * FROM ".$this->tabla." WHERE id=".$id;
	$resultados = $this->conexion->matrizResultados($sql);
	$this->sql = $sql;

	for ($j=0; $j<=count($this->campos)-1; $j++) {
		$nombre_campo = $this->campos[$j];
		$this->$nombre_campo = $resultados[0][$nombre_campo];
	}
}

function insertar(){

	$sql = "SELECT max(id) FROM ".$this->tabla;
	$resultado = $this->conexion->matrizResultados($sql);
	if (empty($resultado)) {
		$siguiente = 1;
	} else {
		$siguiente = $resultado[0]['max(id)']+1;
	}
	$this->id = $siguiente;

	if ($this->tipo == "") {
		$this->tipo_from_nombre();
	}

	$sql = "INSERT INTO ".$this->tabla;
	$sql .= " (id, nombre, lat, lon, altitud, fechahora, descripcion, tipo, pais, region, ciudad, direccion) ";
	$sql .= "VALUES ('".$this->id."', '".$this->nombre."', ".$this->lat.",  ".$this->lon.",'".$this->altitud."','".$this->fechahora."','".$this->descripcion."','".$this->tipo."','".$this->pais."', '".$this->region."', '".$this->ciudad."', '".$this->direccion."')";
	echo ("<br>".$sql);
	if ($this->modoprueba != 1) {
		$this->conexion->ejecutar($sql);
	} else {
		echo "<br> modo prueba__________________________________________";
	}
	$_SESSION['debug'] .= " Lugar insertar: ".$sql;
	return $siguiente;
}

function modificar($id){

	// $this->tipo_from_nombre();
	if ($id != 0) {
		$sql = "UPDATE ".$this->tabla." SET ";
		for ($j=1; $j<=count($this->campos)-1; $j++) {
			$nombre_campo = $this->campos[$j];
			$sql .= $nombre_campo."= '".$this->$nombre_campo."', ";
		}
		$sql = substr($sql, 0, -2);
		$sql .= " WHERE id=".$id;

		$_SESSION['debug'] .= " Lugar modificar: ".$sql;
		// echo "<pre>";print_r($this);
		$this->conexion->ejecutar($sql);
	} else {
		$this->insertar();
	}
}

function eliminar($id){

	$sql = "DELETE FROM ".$this->tabla." WHERE id = '".$id."'";
	$this->conexion->ejecutar($sql);
}

function buscar($decimales, $diferencia_max){

	$lat = round($this->lat, $decimales);
	$lon = round($this->lon, $decimales);
	$sql = "SELECT * FROM ".$this->tabla." WHERE";
	$sql .= " ROUND(lat, ".$decimales.") = ".$lat." AND ROUND(lon, ".$decimales.") = ".$lon;
	echo "<br>".$sql;
	$resultados = $this->conexion->matrizResultados($sql);

	// de los ptos con esas coordenadas, si tienen un nombre suficientemente parecido (en umero de palabras iguales), se consideran el mismo punto
	for ($i=0; $i<count($resultados); $i++){
		echo " nombre en BD: ".$resultados[$i]['nombre']." - nombre en gpx: ".$this->nombre;
		if ($this->compareStrings($resultados[$i]['nombre'], $this->nombre) < $diferencia_max) {
			echo " retirado ";
			unset($resultados[$i]);
		}
	}

	return $resultados;
}

function lista(){

	$sql = "SELECT * FROM ".$this->tabla;
	$sql .= " ORDER BY id_lugar DESC";
	$lugares = $this->conexion->matrizResultados($sql);
	return $lugares;
}

function getCoordinates($address){
	$address = 'Space+Needle';
	$url = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	$response = curl_exec($ch);
	curl_close($ch);
	$result = json_decode($response);
	$ltlg = array($result->results[0]->geometry->location->lat, $result->results[0]->geometry->location->lng);
}

function tipo_from_nombre() {

	$quees = strtolower(explode(" ",$this->nombre)[0]);
	$quees = $this->normaliza($quees);
	echo ('<br> quees: '.$quees);
	// $this->tipo = $quees;
	switch ($quees) {

	   case 'bar':
	   case 'restaurante':
	   case 'pub':
	   case 'meson':
	   case 'chiringuito':
	   case 'nautico':
	   case 'furancho':

	     $this->tipo = "BR";
	     break;

	   case 'alojamiento':
	   case 'camping':
	   	case 'hotel':

	     $this->tipo = "alojamiento";
	     break;

	   case 'punta':
	   case 'cabo':
	   case 'lago':
	   case 'laguna':
	   case 'cascada':
	   case 'fervenza':
	   case 'parque':
	   case 'fraga':
	   case 'cueva':
	   case 'cuevas':
	   case 'cova':
	   case 'duna':
	   case 'monte':
	   case 'sierra':
	   case 'termas':
	   case 'rio':
	   case 'regato':
	   case 'embalse':
	   case 'piedra':
	   case 'acantilado':
	   case 'reserva':
	   case 'peninsula':
	   case 'arbol':
	   case 'bosque':
	   case 'pozas':
	   case 'arrecife':
	   case 'bahia':
	   case 'cala':
	   case 'cañon':
	   case 'montaña':
	   case 'pico':
	   case 'acantilados':
	   case 'fragas':
	   case 'archipielago':
	   case 'barranco':
	   case 'natural':

	 	 $this->tipo = "natural";
	     break;

	   // area recreativa

	   case 'molino':
	   case 'molinos':
	   case 'casa':
	   case 'balneario':
	   case 'pazo':
	   case 'iglesia':
	   case 'ermita':
	   case 'santuario':
	   case 'monasterio':
	   case 'cementerio':
	   case 'puente':
	   case 'ponte':
	   case 'templo':
	   case 'tunel':
	   case 'castro':
	   case 'canal':
	   case 'cantera':
	   case 'cruz':
	   case 'estructura':
	   case 'catedral':
	   case 'monumento':
	   case 'convento':
	   case 'edificacion':
	   case 'cárcel':
	   case 'plaza':
	   case 'presa':
	   case 'refugio':
	   case 'carcel';

	  	 $this->tipo = "estructura";
	     break;

	   case 'fortaleza':
	   case 'castillo':
	   case 'torre':
	   case 'torres':
	   case 'muralla':
	   case 'castelo':
	   case 'fortificacion':

	  	 $this->tipo = "castillo";
	     break;

	   case 'militar':
	   case 'bunker':
	   case 'bunkers':
	   case 'bateria':
	   case 'fuerte':
	   case 'fortin':

	  	 $this->tipo = "militar";
	     break;

	   case 'escalada':
	   case 'cañon':
	   case 'puenting':
	   case 'goming':
	   case 'ruta':
	   case 'paseo':
	   case 'camino':
	   case 'snorkel':
	   case 'buceo':
	   case 'safari':
	   case 'actividad';

	        $this->tipo = "actividad";
	   		break;

	   case 'piscifactoria':
	   case 'depuradora':
	   case 'fabrica':
	   case 'itv';
	   case 'industria':
	        $this->tipo = "industria";
	   		break;

	   case 'dolmen':
	   case 'petroglifo':
	   case 'petroglifos':
	   case 'ruinas':
	   case 'geoglifo':
	   case 'arqueologia':

		  	 $this->tipo = "arqueologia";
		     break;

	   case 'baño':
	   case 'termas':
	   case 'piscina':
	   case 'piscinas':
	   case 'poza':
	   case 'pozas':

		  	 $this->tipo = "baño";
		     break;

		case 'pueblo':
	   case 'ciudad':
	   case 'aldea':

	   		$this->tipo = "poblacion";
		    break;


	   case 'playa':
	   case 'mirador':
	   case 'isla':
	   case 'islas':
	   case 'fuente':
	   case 'amigo':
	   case 'tumba':
	   case 'faro':
	   case 'merendero':
	   case 'museo':
	   case 'geocaching':
	   case 'gasolinera':
	   case 'bomberos':
	   case 'curioso':
	   case 'aeropuerto':
	   case 'hecho':
	   case 'pecio':
	   
	   case 'centro':
	   case 'comercio':
	   case 'animales':
	   case 'puerto':
	   case 'estacion':
	   case 'frontera':
	   case 'furgo':
	   case 'mercado':
	   case 'mina':
	   case 'info':
	   case 'termas':
	   case 'abandonado':

	        $this->tipo = $quees;
	   		break;

       default:
	   		$this->tipo = 'desconocido';
	   		break;
	  }
	  	echo ('<br> this tipo: '.$this->tipo);

}

function actualizarLocalizacion($id, $nombre, $pais, $region, $ciudad, $direccion){

	$direccion=str_replace('\'','',$direccion);
	$ciudad=str_replace('\'','',$ciudad);
	$region=str_replace('\'','',$region);

	$sql = "UPDATE ".$this->tabla." SET ";
	$sql .= "nombre = '".$nombre."', ";
	$sql .= "pais = '".$pais."', ";
	$sql .= "region = '".$region."', ";
	$sql .= "ciudad = '".$ciudad."', ";
	$sql .= "direccion = '".$direccion."' ";
	$sql .= "WHERE id ='".$id."' LIMIT 1 ";
	echo $sql;
	echo "<br>";

	$this->conexion->ejecutar($sql);
	$_SESSION['debug'] .= " Lugar actualizarLocalizacion: ".$sql;
}

// compara el % de palabras en el que coinciden
function compareStrings($s1, $s2) {
    //one is empty, so no result
    if (strlen($s1)==0 || strlen($s2)==0) {
        return 0;
    }

    //replace none alphanumeric charactors
    //i left - in case its used to combine words
    $s1clean = preg_replace("/[^A-Za-z0-9-]/", ' ', $s1);
    $s2clean = preg_replace("/[^A-Za-z0-9-]/", ' ', $s2);

    //remove double spaces
    while (strpos($s1clean, "  ")!==false) {
        $s1clean = str_replace("  ", " ", $s1clean);
    }
    while (strpos($s2clean, "  ")!==false) {
        $s2clean = str_replace("  ", " ", $s2clean);
    }

    //create arrays
    $ar1 = explode(" ",$s1clean);
    $ar2 = explode(" ",$s2clean);
    $l1 = count($ar1);
    $l2 = count($ar2);

    //flip the arrays if needed so ar1 is always largest.
    if ($l2>$l1) {
        $t = $ar2;
        $ar2 = $ar1;
        $ar1 = $t;
    }

    //flip array 2, to make the words the keys
    $ar2 = array_flip($ar2);


    $maxwords = max($l1, $l2);
    $matches = 0;

    //find matching words
    foreach($ar1 as $word) {
        if (array_key_exists($word, $ar2))
            $matches++;
    }

    return ($matches / $maxwords) * 100;    
}

function localizar(){

	require_once ("clases/clase.localizador.php");
	$localizador = new localizador;
	$localizador->direccionDelPunto($this->lon, $this->lat);

	$this->pais = $localizador->pais;
	$this->region = $localizador->region;
	$this->ciudad = $localizador->ciudad;
	$this->direccion = $localizador->direccion;

}

function normaliza ($cadena){
    $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞ
ßàáâãäåæçèéêëìíîïðòóôõöøùúûýýþÿŔŕ';
    $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuy
bsaaaaaaaceeeeiiiidoooooouuuyybyRr';
    $cadena = utf8_decode($cadena);
    $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
    $cadena = strtolower($cadena);
    return utf8_encode($cadena);
}

function agregarAUsuario($lugar, $usuario){

	$sql = "INSERT INTO usuarios_has_lugares";
	$sql .= " (id_usuario, id_lugar) ";
	$sql .= "VALUES ('".$usuario."', '".$lugar."')";
	$this->conexion->ejecutar($sql);
	// echo $sql;

	$_SESSION['debug'] .= " Lugar agregar: ".$sql;
}

function retirarDeUsuario($lugar, $usuario){

	$sql = "DELETE FROM usuarios_has_lugares";
	$sql .= " WHERE id_usuario='".$usuario."' AND id_lugar='".$lugar."'";
	$this->conexion->ejecutar($sql);
	// echo $sql;

	$_SESSION['debug'] .= " Lugar agregar: ".$sql;
}

# CONVERSOR DE COORDENADAS XY A GPS ::::::::::::::::::::::::::::::::::::::::::::::::::

function conversorToLL($north, $east, $utmZone){ 
  // This is the lambda knot value in the reference
  $LngOrigin = Deg2Rad($utmZone * 6 - 183);

  // The following set of class constants define characteristics of the
  // ellipsoid, as defined my the WGS84 datum.  These values need to be
  // changed if a different dataum is used.    

  $FalseNorth = 0;   // South or North?
  //if (lat < 0.) FalseNorth = 10000000.  // South or North?
  //else          FalseNorth = 0.   

  $Ecc = 0.081819190842622;       // Eccentricity
  $EccSq = $Ecc * $Ecc;
  $Ecc2Sq = $EccSq / (1. - $EccSq);
  $Ecc2 = sqrt($Ecc2Sq);      // Secondary eccentricity
  $E1 = ( 1 - sqrt(1-$EccSq) ) / ( 1 + sqrt(1-$EccSq) );
  $E12 = $E1 * $E1;
  $E13 = $E12 * $E1;
  $E14 = $E13 * $E1;

  $SemiMajor = 6378137.0;         // Ellipsoidal semi-major axis (Meters)
  $FalseEast = 500000.0;          // UTM East bias (Meters)
  $ScaleFactor = 0.9996;          // Scale at natural origin

  // Calculate the Cassini projection parameters

  $M1 = ($north - $FalseNorth) / $ScaleFactor;
  $Mu1 = $M1 / ( $SemiMajor * (1 - $EccSq/4.0 - 3.0*$EccSq*$EccSq/64.0 - 5.0*$EccSq*$EccSq*$EccSq/256.0) );

  $Phi1 = $Mu1 + (3.0*$E1/2.0 - 27.0*$E13/32.0) * sin(2.0*$Mu1);
    + (21.0*$E12/16.0 - 55.0*$E14/32.0)           * sin(4.0*$Mu1);
    + (151.0*$E13/96.0)                          * sin(6.0*$Mu1);
    + (1097.0*$E14/512.0)                        * sin(8.0*$Mu1);

  $sin2phi1 = sin($Phi1) * sin($Phi1);
  $Rho1 = ($SemiMajor * (1.0-$EccSq) ) / pow(1.0-$EccSq*$sin2phi1,1.5);
  $Nu1 = $SemiMajor / sqrt(1.0-$EccSq*$sin2phi1);

  // Compute parameters as defined in the POSC specification.  T, C and D

  $T1 = tan($Phi1) * tan($Phi1);
  $T12 = $T1 * $T1;
  $C1 = $Ecc2Sq * cos($Phi1) * cos($Phi1);
  $C12 = $C1 * $C1;
  $D  = ($east - $FalseEast) / ($ScaleFactor * $Nu1);
  $D2 = $D * $D;
  $D3 = $D2 * $D;
  $D4 = $D3 * $D;
  $D5 = $D4 * $D;
  $D6 = $D5 * $D;

  // Compute the Latitude and Longitude and convert to degrees
  $lat = $Phi1 - $Nu1*tan($Phi1)/$Rho1 * ( $D2/2.0 - (5.0 + 3.0*$T1 + 10.0*$C1 - 4.0*$C12 - 9.0*$Ecc2Sq)*$D4/24.0 + (61.0 + 90.0*$T1 + 298.0*$C1 + 45.0*$T12 - 252.0*$Ecc2Sq - 3.0*$C12)*$D6/720.0 );

  $lat = Rad2Deg($lat);

  $lon = $LngOrigin + ($D - (1.0 + 2.0*$T1 + $C1)*$D3/6.0 + (5.0 - 2.0*$C1 + 28.0*$T1 - 3.0*$C12 + 8.0*$Ecc2Sq + 24.0*$T12)*$D5/120.0) / cos($Phi1);

  $lon = Rad2Deg($lon);

  return array($lat, $lon);

  // Create a object to store the calculated Latitude and Longitude values
  /*$PC_LatLon['lat'] = $lat;
  $PC_LatLon['lon'] = $lon;

  // Returns a PC_LatLon object
  return $PC_LatLon;*/
}

}

?>
