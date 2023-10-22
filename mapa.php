<link rel="stylesheet" href="http://dev.openlayers.org/theme/default/style.css" type="text/css">

<style>
    .olControlFeaturePopups_list{font-size: 80%;}
    .olControlFeaturePopups_list ul{margin-bottom: 0}
</style>

<script src="http://dev.openlayers.org/OpenLayers.js"></script>

<script src="00.modulos/open_layers/featurepopups/patches_OL-popup-autosize.js"></script>
<script src="00.modulos/open_layers/featurepopups/FeaturePopups.js"></script>

<script src="scripts/interfazOL.js"></script>

<?php
// session_start();
include "estilos-links.php";
require_once ("clases/clase.generalista.php");
require_once ("clases/clase.localizador.php");
$generador = new generaLista($usuario);
$localizador = new localizador;

$pais_mapa = "";
if (isset ($_GET['pais'])) {
  $pais_mapa = $_GET['pais'];
  $localizador->centroidesDelPais($pais_mapa);
}

if (!isset($ancho) || $ancho == '') {
  $ancho = 500;
}
if (!isset($alto) || $alto == '') {
  $alto = ($ancho*1.2);
}

$estilomapa = "width: ".$ancho."px; height: ".$alto."px; position: fixed; top: ".$arriba.";";

if (isset ($_GET['tipomapa']) && $_GET['tipomapa'] == "grande") {
  $estilomapa .= " left: ".$izquierda.";";
} else {
  $estilomapa .= " right: ".$derecha.";";
}
echo $estilomapa;

?>

<div id="mapa" style="<?php echo $estilomapa ?>" class="smallmap"></div>

<script src="scripts/mapa.api.js"></script>

<?php

if ($pais_mapa != "") {
  echo "<script> centrar(".$localizador->lon.", ".$localizador->lat.", 5) </script>";
}

for ($j=0; $j<count($tipos); $j++) { 
  $tipo = $tipos[$j]['tipo']; $tipo = str_replace("-","_",$tipo);

  // echo "<script> window.alert('crearcapa ".$tipo."') </script>";
  echo "<script> crearCapa('".$tipo."') </script>";

  $resultados = $generador->generarListaLugares (false, $tipos[$j]['tipo'], $pais_mapa);

  for ($i=0; $i<count($resultados); $i++){
    $id=$resultados[$i]['id'];
    $nombre=$resultados[$i]['nombre'];
    // $tipo=$resultados[$i]['tipo'];
    $lat=$resultados[$i]['lat'];
    $lon=$resultados[$i]['lon'];

    if (($lat != "") && ($lon != "")) {
      // echo "<script> window.alert('crearmarcador ".$nombre."') </script>";
      echo "<script> crearMarcador('".$lat."', '".$lon."', '".$nombre."', '".$tipo."') </script>";
?>

<?php } } ?>
<?php } ?>