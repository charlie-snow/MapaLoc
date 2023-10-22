<?php
	header ('Content-Type: text/html; charset=utf-8');
	 error_reporting(E_ALL);
	 ini_set('display_errors', '1');
	session_start();

	require_once("clases/clase.conexion.php");
	
	if(!isset($_SESSION['usuario_id'])){ header("location:login.form.php"); }

   	if(!isset($_SESSION['error'])){ $_SESSION["error"] = ""; }

   	if(!isset($_SESSION['mensaje_error'])){ $_SESSION["mensaje_error"] = ""; }

	if(!isset($_SESSION['debug'])){ $_SESSION["debug"] = ""; }

	$_SESSION["volver"] = "$_SERVER[REQUEST_URI]";

	if(!isset($_SESSION['modoprueba'])){ $_SESSION["modoprueba"] = 1; }

	$_SESSION['opciones'] = 10; // son las que permite la bd como está	
	$_SESSION['npreguntas'] = 50;

	$usuario = $_SESSION['usuario_id'];
	if (isset ($_GET['usuario'])) {
		$usuario = $_GET['usuario'];
	}
	// echo $usuario;

	if (!isset ($_SESSION['tabla'])) {
		switch ($usuario) {
			case 0:
				$tabla = "lugares";
		   		break;
			case 4:
		        $tabla = "lugares_bom";
		   		break;
		   	default:
		   		$tabla = "lugares";
		   		break;
	 	}
	 	$_SESSION['tabla'] = $tabla;
	}
?>

<link rel="STYLESHEET" type="text/css" href="scripts/flags/flags.css">

<html>
<head>
	<title>MapaLoc</title>
	
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta name="author" content="tati" />
	<meta name="copyright" content="101 design &copy; 2016" />
	<meta name="description" content="" />
	<meta name="keywords" content="charche, xtreme posing, tati, charchenegger" />

	<meta name="MSSmartTagsPreventParsing" content="TRUE" />
	<meta name="generator" content="personal tati" />
	
	<link rel="STYLESHEET" type="text/css" href="estilos.css">
	<link rel="STYLESHEET" type="text/css" href="links.css">
</head>
<body>
<!-- alinear -->
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color:#fff7d9;">
<tr valign="top">
	<td align="center" valign="middle">
<!-- -->

<?php include ("seccion.web.php"); ?>

<!-- -->
	</td>
</tr>
</table>


</body>
</html>