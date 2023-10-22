<?php
// session_start();
include "estilos-links.php";
require_once ("clases/clase.localizador.php");
$localizador = new localizador;
?>

<table border="1" cellspacing="0" cellpadding="5" align="center">
<tr>
    <td>
    Zonas geográficas: &nbsp;&nbsp;
    <a href="#" onclick="centrar(lonGalicia, latGalicia, zoomGalicia)"; return false> Galicia </a> | 
    <a href="#" onclick="centrar(lonEspaña, latEspaña, zoomEspaña)"; return false> España </a> | 
    <a href="#" onclick="centrar(0, 0, 0)"; return false> Mundo </a>
    &nbsp;&nbsp; Países (<?php echo count($paises) ?>): 

        <?php for ($j=0; $j<count($paises); $j++) { 
                $pais = $paises[$j]['pais'];
                $localizador->centroidesDelPais($pais); ?>
        <img src="blank.gif" class="flag flag-<?php echo strtolower($pais); ?>" alt="<?php echo $pais; ?>&usuario=0" />
        <a onclick="centrar(<?php echo $localizador->lon ?>, <?php echo $localizador->lat ?>, 5)" href="#"> centrar </a> | 
        <a href="index.php?contenido=lugares&mapa=1&tipo=lugares&pais=<?php echo $pais; ?>&usuario=0">lista </a>

        <?php } ?>
    <a href="#" onclick="centrar(lonBomberos, latBomberos, zoomBomberos)"; return false> Zona de actuación </a>
    </td>
</tr>
</table>
