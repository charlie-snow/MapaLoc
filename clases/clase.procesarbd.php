<?php

class procesarBD {

function procesarBD() {

	require_once ("clases/clase.conexion.php");
	$this->conexion = new conexionMYSQL;
	$this->conexion->conectar();

}

function clasificarXnombre(){

	require_once ("clases/clase.lugar.php");
	$lugar = new lugar($usuario);

	$sql = "SELECT * FROM lugares";
	$resultados = $this->conexion->matrizResultados($sql);

	for ($i=0; $i<count($resultados); $i++){
		$id=$resultados[$i]['id'];
		$nombre=$resultados[$i]['nombre'];
		$tipo=$resultados[$i]['tipo'];
		$lat=$resultados[$i]['lat'];
		$lon=$resultados[$i]['lon'];
		$pais=$resultados[$i]['pais'];
		$ciudad=$resultados[$i]['ciudad'];
		$region=$resultados[$i]['region'];
		$direccion=$resultados[$i]['direccion'];
		$notas=$resultados[$i]['notas'];

		$lugar->nombre = $nombre;
		$lugar->lat = $lat;
		$lugar->lon = $lon;
		$lugar->pais = $pais;
		$lugar->region = $region;
		$lugar->ciudad = $ciudad;
		$lugar->direccion = $direccion;

		// echo "<pre>"; print_r($lugar);

		$lugar->tipo_from_nombre();

		echo "<br> tipo: ".$tipo;
		echo " - tipo nuevo: ".$lugar->tipo;

		if (($lugar->tipo != $tipo) && ($lugar->tipo != "desconocido")) {
			$lugar->modificar($id);
		}

		// if ($lugar->tipo != "desconocido") {
		// 	$lugar->modificar($id);
		// }
	}



	return $resultados;
}

function generarListaLugaresNoLocalizados($cantidad, $xnombre, $tipo){

	$sql = "SELECT * FROM lugares ";
	$sql .= "WHERE pais IS NULL ";
	if ($tipo <> 'lugares') {
		$sql .= "AND tipo = '".$tipo."' ";
	}	
	if ($xnombre) {
		$sql .= "ORDER BY nombre ASC";
	} else {
		$sql .= "ORDER BY id ASC";
	}
	$sql .= " LIMIT ".$cantidad;

	echo $sql;
	$resultados = $this->conexion->matrizResultados($sql);
	return $resultados;
}

}

?>
