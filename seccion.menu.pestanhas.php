<?php
// session_start();
include "estilos-links.php";
?>

<table border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
	<td>	
		<a href="index.php?contenido=lugares&mapa=1&tipo=lugares&usuario=0">Mapa de Lugares</a> &nbsp;&nbsp; |&nbsp;&nbsp;
		<a href="index.php?contenido=lugares&mapa=1&tipo=tracks&usuario=0">Mapa de Tracks</a> &nbsp;&nbsp; |&nbsp;&nbsp;
		<a href="index.php?contenido=admin">Admin</a> &nbsp;&nbsp;
	</td>
	<td>
		Mapas de <?php echo $_SESSION['usuario_nombre']; ?>: 
		<a href="index.php?contenido=lugares&mapa=1&tipo=lugares">Mapa de Lugares</a> &nbsp;&nbsp; |&nbsp;&nbsp;
		<a href="index.php?contenido=lugares&mapa=1&tipo=tracks">Mapa de Tracks</a> 
	</td>
</tr>
</table>
