<?php
	header ('Content-Type: text/html; charset=utf-8');
	 error_reporting(E_ALL);
	 ini_set('display_errors', '1');
	session_start();

	require_once("clases/clase.conexion.php");

   	if(!isset($_SESSION['error'])){ $_SESSION["error"] = ""; }

   	if(!isset($_SESSION['mensaje_error'])){ $_SESSION["mensaje_error"] = ""; }

	if(!isset($_SESSION['debug'])){ $_SESSION["debug"] = ""; }

	if(!isset($_SESSION['volver'])){ $_SESSION["volver"] = ""; }

	$usuario = 0;
	
	if (isset ($_GET['usuario'])) {
		$usuario = $_GET['usuario'];
	}
	// echo $usuario;
	// $_SESSION['usuario_id'] = $usuario;

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

	<meta name="MSSmartTagsPreventParsing" content="TRUE" />
	<meta name="generator" content="personal tati" />
	
	<link rel="STYLESHEET" type="text/css" href="estilos.css">
	<link rel="STYLESHEET" type="text/css" href="links.css">
</head>
<body>
<!-- alinear -->

<!-- -->

	
				
<!--                                                                                 -->


				<?php
				require_once ("clases/clase.generalista.php");
				$generador = new generaLista($usuario);

				$volver = "";

				$mapa = true;
			

				$tipos = array();
				$tipomapa = '';

				if (!isset($_GET['tipo'])) {
					$tipomapa = "lugares";
					$volver .= "lugares";
				} else {
					$tipomapa = $_GET['tipo'];
				}
				if ($tipomapa == "lugares") {
					$tipos = $generador->listaTipos ();
				} else {
					$tipos[0]['tipo'] = $tipomapa;
				}


				if ($mapa) {
					$ancho = 900; $alto = 1200; $arriba = 0; $izquierda = 0; $tipo = $tipomapa; include "mapa.php";
				}

				?>

				<script> centrar(-7.76070330, 42.71659040, 11) </script>

				<?php include "estilos-links.php"; ?>

				



<!--                                                                                  -->



<!-- -->



</body>
</html>