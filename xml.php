<?php
$xml=simplexml_load_file("output/lugares.kml", 'SimpleXMLElement', LIBXML_NOCDATA) or die("Error: Cannot create object");
$array = json_decode(json_encode((array)$xml), TRUE);
echo "<pre>"; print_r($array);
?> 
