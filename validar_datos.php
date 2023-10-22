<?php

function valido($cadena, $validos){

	$vale = true;
	for ($i=0; $i < strlen($cadena); $i++) {
		if (strchr($validos, $cadena[$i]) == false) {
			$vale = false;
		}
	}
	return $vale;
}

function validoLogin($cadena){

	$validos = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_.';
	return (valido($cadena, $validos) AND strlen($cadena) <= 10 AND strlen($cadena) > 0);
}

function validoTexto($cadena){

	$validos = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_?.,;:@ '; //ªºáéíóúÁÉÍÓÚñÑ¿; ()/';
	$especiales = chr(225).chr(233).chr(237).chr(243).chr(250).chr(241).chr(209); // áéíóúñÑ
	$validos = $validos.$especiales;
	return ($cadena == '' OR valido($cadena, $validos));
}

function validoTitulo($cadena){

	$validos = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_?.,;:@ '; //ªºáéíóúÁÉÍÓÚñÑ¿; ()/';
	$especiales = chr(225).chr(233).chr(237).chr(243).chr(250).chr(241).chr(209); // áéíóúñÑ
	$validos = $validos.$especiales;
	return (valido($cadena, $validos) AND $cadena!='');
}

function validoLetra($letra){

	$validos = 'abcdefghijklmnopqrstuvwxyz';
	return ($letra == '' OR valido($letra, $validos) AND strlen($letra) == 1);
}

function validoEmail($email){

	return ($email == '' OR ereg('^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$', $email) AND strlen($email) <= 30);
}

function validoEmailPeticion($email){

	return (ereg('^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$', $email) AND strlen($email) <= 30);
}

function validoEstado($estado) {

	return ($estado == 'activo' OR $estado == 'inactivo' OR $estado == 'peticion');
}

function validoNumero($numero) {

	return ($numero > 0 AND ctype_digit($numero) AND $numero < 1000);
}

function validoTelefono($telefono) {

	return ($telefono == '' OR ctype_digit($telefono) AND strlen($telefono) <= 12);
}

function validoBooleano($booleano) {

	return ($booleano == 0 OR $booleano == 1);
}

function validoOrden($orden) {

	return ($orden == '' OR (ereg('[0-9]', $orden) AND $orden < 100));
}

function validoRespuesta($respuesta) {

	return ($respuesta == 0 OR $respuesta == 1 OR $respuesta == 2);
}

// ----------------------------------------------------------------------------------------------------

function validarAutentica($login, $password){

	return (validoLogin($login) AND validoLogin($password));
}
/*
function validarUsuario($login, $password, $nombre, $direccion, $email, $telefono){

	return (validoLogin($login) AND validoLogin($password) AND validoTexto($nombre) AND validoTexto($direccion) AND validoEmail($email) AND validoTelefono($telefono));
}
*/
function validarLog($texto){

	if (validoTexto($texto)) {
		$valido = true;
	} else {
		$valido = false;
	}
	return $valido;
}

/*
function validarRespuesta($respuesta, $xref_respuesta){

	return (validoRespuesta($respuesta) AND validoTexto($xref_respuesta));
}

function validarFormulario($titulo, $activo_formulario, $orden){

	return (validoTitulo($titulo) AND validoBooleano($activo_formulario) AND validoOrden($orden));
}



function validarTextos($si, $no, $informacion){

	return (validoTexto($si) AND validoTexto($no) AND validoTexto($informacion));
}*/

?>
