<?php
	if (!isset($_REQUEST["contenido"])) {
		//$_REQUEST["contenido"] = "pre_moz";
		$_REQUEST["contenido"] = "seccion.inicio";
		//$_REQUEST["contenido"] = "donde";
	}
?>

<div id="contenido">
	<?php include $_REQUEST["contenido"].".php" ?> 
</div>

