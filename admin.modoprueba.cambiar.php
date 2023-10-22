<?php
	header ('Content-Type: text/html; charset=utf-8');
	 error_reporting(E_ALL);
	 ini_set('display_errors', '1');
	session_start();

	if ($_SESSION['modoprueba'] == 1) {
		$_SESSION['modoprueba'] = 0;
	} else {
		$_SESSION['modoprueba'] = 1;
	}

	header ("Location:".$_SESSION['volver']);
?>