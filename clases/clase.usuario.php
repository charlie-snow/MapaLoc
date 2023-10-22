<?php

class usuario {

var $id;
var $nombre;
var $nivel;
var $password;
var $fecha_ingreso;
var $visitas;
var $uid_facebook;

function usuario() {

	require_once ("clase.conexion.php");
	$this->conexion = new conexionMYSQL;
	$this->conexion->conectar();
}

function insertar (){
	$sql = "INSERT INTO usuarios (nombre, nivel, uid_facebook, fecha_ingreso, visitas) ";
	$sql .= "VALUES ('".$this->nombre."', '".$this->nivel."', '".$this->uid_facebook."', CURDATE( ), 0)";
	
	$this->conexion->ejecutar($sql);
	// echo $sql;
}

function eliminar($id){

	$sql = "DELETE FROM usuarios WHERE id = '".$id."'";
	$this->conexion->ejecutar($sql);
	//echo $sql;
}

function actualizar($id){

	$sql = "UPDATE usuarios SET nombre='".$this->nombre."'";
	$sql .= " WHERE id='".$id."'";
	$this->conexion->ejecutar($sql);
}

function recuperar($id){
	
	$sql = "SELECT * FROM usuarios WHERE id='".$id."'";
	$resultados = $this->conexion->matrizResultados($sql);
	return $resultados;
}

function existe(){
	$existe = 0;
	$sql = "SELECT id from usuarios WHERE uid_facebook = '".$this->uid_facebook."'";
	// echo $sql;
	$resultados = $this->conexion->matrizResultados($sql);
	if (count($resultados) > 0) {
		$existe = 1;
	} else {
		$existe = 0;
	}
	return $existe;
}

function get_datos(){
	
	$sql = "SELECT id, nombre, password, nivel, visitas FROM usuarios WHERE id='".$this->id."'";
	$resultados = $this->conexion->matrizResultados($sql);
	$this->id = $resultados[0][0];
	$this->nombre = $resultados[0][1];
	$this->password = $resultados[0][2];
	$this->nivel = $resultados[0][3];
	$this->visitas = $resultados[0][4];
}

function get_datos_nombre(){
	
	$sql = "SELECT id, nombre, password, nivel, visitas FROM usuarios WHERE nombre='".$this->nombre."'";
	$resultados = $this->conexion->matrizResultados($sql);
	$this->id = $resultados[0]['id'];
	$this->nombre = $resultados[0]['nombre'];
	$this->password = $resultados[0]['password'];
	$this->nivel = $resultados[0]['nivel'];
	$this->visitas = $resultados[0]['visitas'];
}

function nueva_visita(){
	$visitas = $this->visitas+1;
	$sql = "UPDATE usuarios SET visitas='".$visitas."'";
	$sql .= " WHERE id='".$this->id."'";
	$this->conexion->ejecutar($sql);
}

function acceso_permitido($nombre, $password){
	$acceso = 0;
	$sql = "SELECT password from usuarios WHERE nombre = '".$nombre."'";
	$resultados = $this->conexion->matrizResultados($sql);
	// echo $sql." - ".$password." - ".$resultados[0]['password'];
	// echo "<pre>"; print_r($resultados);
	if ($resultados[0]['password'] == $password) {
		$acceso = 1;
	} else {
		$acceso = 0;
	}
	return $acceso;
}

}

?>
