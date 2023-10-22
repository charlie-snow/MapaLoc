<p><big>CLASIFICACIÓN POR NOMBRE</big></p>

<?php
require_once ("clases/clase.procesarbd.php");
$procesarbd = new procesarbd;

$_SESSION['volver'] = "index.php?contenido=admin.localizar";

$procesarbd->clasificarXnombre();
?>