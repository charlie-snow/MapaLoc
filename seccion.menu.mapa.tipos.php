<?php
// session_start();
include "estilos-links.php";
?>

<div id="menu_tipos">
<table border="1" cellspacing="0" cellpadding="0" align="center">
	<tr>
      <td align="center">
        	<a onclick="limpiarMapa()" href="#">limpiar</a>
      </td>
    </tr>
    <tr>
      <td align="left">
        	Tipos (<?php echo count($tipos) ?>): &nbsp;&nbsp; <br>

			<?php for ($j=0; $j<count($tipos); $j++) { 
		        $tipo = $tipos[$j]['tipo']; ?>
		        <img src="./img/<?php echo $tipos[$j]['tipo']; ?>.png" height="20" width="20">
		        <a onclick="cambiarVisibilidadCapa('<?php echo $tipo ?>')" href="#"><?php echo $tipo ?></a> <br>
		    <?php } ?>
      </td>
    </tr>
</table>
</div>
