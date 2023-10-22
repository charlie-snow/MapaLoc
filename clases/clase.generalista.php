<?php

class generaLista {

var $ntipos, $npaises, $nlugares, $ntracks;

function __construct($usuario = null) {

	$this->usuario = $_SESSION['usuario_id'];
	$this->tabla = $_SESSION['tabla'];

	// $usuario = $_SESSION['usuario_id'];
	// if (isset ($_GET['usuario'])) {
	// 	$this->usuario = $_GET['usuario'];
	// }

	// if ($usuario == null) {
	// 		$this->tabla = 'lugares';
	// 	} else {
	// 		if ($usuario == 4) {
	// 			$this->tabla = 'lugares_bom';
	// 		}
	// 	}

	// if ($usuario == null) {
	// 	$this->tabla = 'lugares';
	// } else {
	// 	if ($usuario == 4) {
	// 		$this->tabla = 'lugares_bom';
	// 	}
	// }
	require_once ("clases/clase.conexion.php");
	$this->conexion = new conexionMYSQL;
	$this->conexion->conectar();

}

function recopilarDatos (){

	$sql = "SELECT DISTINCT tipo FROM ".$this->tabla;
	$sql .= " ORDER BY tipo";
	$this->tipos = $this->conexion->matrizResultados($sql);
	
	$sql = "SELECT DISTINCT id FROM ".$this->tabla;
	$sql .= " ORDER BY id";
	$this->lugares = $this->conexion->matrizResultados($sql);

	$sql = "SELECT DISTINCT pais FROM ".$this->tabla;
	$sql .= " ORDER BY pais";
	$this->paises = $this->conexion->matrizResultados($sql);
}

function listaTipos (){

	$sql = "SELECT DISTINCT tipo FROM ".$this->tabla;
	$sql .= " ORDER BY tipo";
	// echo $sql;
	$tipos = $this->conexion->matrizResultados($sql);
	return $tipos;
}

function generarListaLugares($orden, $tipo, $pais){

	switch ($this->usuario) {

		case 0:
		case 1: // si es el usuario puntos
			$sql = "SELECT * FROM ".$this->tabla." t1 WHERE true ";
	   		break;
		case 4:
	        $sql = "SELECT * FROM ".$this->tabla." t1 WHERE true ";
	   		break;

	   	default:
	   		$sql="SELECT t1.* FROM ".$this->tabla." t1 LEFT JOIN usuarios_has_lugares t2 ON t1.id = t2.id_lugar WHERE t2.id_usuario =".$this->usuario." ";
	   		break;
 	}

	if ($tipo <> 'lugares') {
		$sql .= "AND t1.tipo = '".$tipo."' ";
		if ($pais <> '') {
			$sql .= "AND t1.pais = '".$pais."' ";
		}
	} else {
		if ($pais <> '') {
			$sql .= "AND t1.pais = '".$pais."' ";
		}
	}
	
	switch ($orden) {

	   case 'nombre':
	     $sql .= "ORDER BY t1.nombre ASC, ciudad ASC";
	     break;

	   case 'latitud':
	     $sql .= "ORDER BY t1.lat DESC";
	     break;

	   case 'ciudad':
	     $sql .= "ORDER BY t1.ciudad ASC, nombre ASC";
	     break;

       default:
	   		$sql .= "ORDER BY t1.id ASC";
	   		break;
	}
	// echo $sql;
	$resultados = $this->conexion->matrizResultados($sql);
	return $resultados;
}

function generarListaLugaresNoLocalizados($cantidad, $xnombre, $tipo){

	$sql = "SELECT * FROM ".$this->tabla." ";
	$sql .= "WHERE pais IS NULL OR pais = '' ";
	if ($tipo <> 'lugares') {
		$sql .= "AND tipo = '".$tipo."' ";
	}	
	if ($xnombre) {
		$sql .= "ORDER BY nombre ASC";
	} else {
		$sql .= "ORDER BY id ASC";
	}
	if ($cantidad != 0) {
		$sql .= " LIMIT ".$cantidad;
	}

	$_SESSION['debug'] .= " Lista lugares no localizados: ".$sql;
	$resultados = $this->conexion->matrizResultados($sql);
	return $resultados;
}

function generarListaLugaresNoClasificados($cantidad, $xnombre){

	$sql = "SELECT * FROM ".$this->tabla." ";
	$sql .= "WHERE tipo IS NULL OR tipo = 'desconocido' ";	
	if ($xnombre) {
		$sql .= "ORDER BY nombre ASC";
	} else {
		$sql .= "ORDER BY id ASC";
	}
	if ($cantidad != 0) {
		$sql .= " LIMIT ".$cantidad;
	}

	$_SESSION['debug'] .= " Lista lugares no clasificados: ".$sql;
	$resultados = $this->conexion->matrizResultados($sql);
	return $resultados;
}

}

?>
