<?php
	session_start();

include "estilos-links.php";

require_once ("clases/clase.generalista.php");

$usuario = $_SESSION['usuario_id'];
if (isset ($_GET['usuario'])) {
	$usuario = $_GET['usuario'];
}

if(isset($_GET['tipo'])){ $tipo = $_GET['tipo']; }
if(isset($_GET['pais'])){ $pais = $_GET['pais']; }

$generador = new generaLista;

$resultados = $generador->generarListaLugares ('ciudad', $tipo, $pais);

$html = '<table border="0" cellspacing="1" cellpadding="1" align="center" width="700">
<tr>
	<td align="Center">Concello</td>
	<td align="Center">tipo</td>
	<td align="Center">Nome</td>
	<td align="Center"></td>
</tr>
<tr>';

for ($i=0/*count($resultados)-5*/; $i<count($resultados); $i++){
	// $res = preg_replace("/[^a-zA-Z0-9]/", "", $resultados[$i]['id']);
	// $id=$res;
	
	// $res = preg_replace("/[^a-zA-Z0-9\s]/", "", $resultados[$i]['nombre']);
	// $nombre=$res;

	$id=$resultados[$i]['id'];
	$nombre=$resultados[$i]['nombre'];
	$entreparentesis = "";

	if (strpos($nombre, "(") != 0) {
		$entreparentesis = substr($nombre, strpos($nombre, "("), strlen($nombre));
		$nombre = substr($nombre, 0, strpos($nombre, "("));
	}

	$tipo=$resultados[$i]['tipo'];
	$lat=$resultados[$i]['lat'];
	$lon=$resultados[$i]['lon'];
	$region=$resultados[$i]['region'];
	$ciudad=$resultados[$i]['ciudad'];
	
	$res = preg_replace("/[^a-zA-Z0-9\s]/", "", $resultados[$i]['notas']);
	$notas=$res;

	$html .= '<td align="Center"><img src="./img/bomberos/';

	switch ($ciudad) {
			case 'Antas de Ulla':
				$html .= 'antas';
				break;
			case 'Chantada':
				$html .= 'chantada';
				break;
			case 'Guntín':
				$html .= 'guntin';
				break;
			case 'Portomarín':
				$html .= 'portomarin';
				break;
			case 'Saviñao':
				$html .= 'savinhao';
				break;
			case 'Carballedo':
				$html .= 'carballedo';
				break;
			case 'Ferreira de Pantón':
				$html .= 'panton';
				break;
			case 'Taboada':
				$html .= 'taboada';
				break;
			case 'Monterroso':
				$html .= 'moterroso';
				break;
			case 'Palas':
				$html .= 'palas';
				break;
  	} 

  	$html .= '.png" height="50" width="50"><br>'.$ciudad.'</td>
	<td align="Center"><img src="./img/'.$tipo.'.png" height="50" width="50"></td>
	<td align="Left"><a href=http://maps.google.com/maps?q='.$lat.','.$lon.'><h1 class="texto_gigante">'.$nombre.'</h1></a></td>
	<td align="Center">'.$entreparentesis.'</td></tr>';

}
$html .= '</table>';
echo $html;
?>
