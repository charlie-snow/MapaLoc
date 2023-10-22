<?php

class conexionMYSQL {

var $basedatos = '';
var $servidor = '';
var $usuario = '';
var $clave = '';

var $enlace = 0;
var $consulta = 0;

function __construct($basedatos = 'mapaloc', $servidor = 'localhost', $usuario = 'mapaloc', $clave = 'mapaloc') {

	$this->basedatos = $basedatos;
	$this->servidor = $servidor;
	$this->usuario = $usuario;
	$this->clave = $clave;

}

/*----------------------------- CONEXION --------------------------------------------*/

function conectar() {

	$this->enlace = mysqli_connect ($this->servidor, $this->usuario, $this->clave);
	if (!$this->enlace) {
		echo ("error al conectar: ");
		echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
	    echo "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
	    echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
		return 0;												//para que salga
	}
	mysqli_select_db ($this->enlace, $this->basedatos) or die ("error al acceder a la BD");
	mysqli_set_charset($this->enlace, 'utf8');
	mysqli_query($this->enlace, "SET NAMES 'utf8'");
}

function desconectar() {

	if ($this->enlace) {
		mysql_close($this->enlace);
	} else {
		echo ("no hay bases de datos abiertas");
	}
}

/*----------------------------- ACCIONES --------------------------------------------*/

function ejecutar ($sql) {

	if ($sql == "") {
		echo ("error: no se ha especificado la consulta sql");
		return 0; 											//para que salga
	}

	$this->consulta = mysqli_query ($this->enlace, $sql);
	if (!$this->consulta) {
		echo ("fallo al realizar la consulta sql");
	}
}

function matrizResultados ($sql){
	// echo $sql;
	$this->ejecutar($sql);
		$resultados = array();
	while( $row = mysqli_fetch_assoc($this->consulta) ) {
	     $resultados[] = $row;
	}
	return $resultados;
}

function unResultado ($sql){

	$this->ejecutar($sql);
	$i=0;
	$resultados = mysql_fetch_row ($this->consulta);
	return $resultados[0];
}
}

?>
