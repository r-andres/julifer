<?php


$files = array(
    'AdminLogin' => 'parts/AdminLogin.php',
    'ClienteList' => 'parts/ClienteListWidget.php',
    'ClienteForm' => 'parts/ClienteFormWidget.php',
    'ClienteSearch' => 'parts/ClienteSearchWidget.php',
    'ClienteView' => 'parts/ClienteViewWidget.php',
    'MaterialList' => 'parts/MaterialListWidget.php',
    'MaterialForm' => 'parts/MaterialFormWidget.php',
    'FacturaList' => 'parts/FacturaListWidget.php',
    'FacturaForm' => 'parts/FacturaFormWidget.php',
    'FacturaPdf' => 'parts/FacturaPdfWidget.php',
	'FacturaSearch' => 'parts/FacturaSearchWidget.php',
	'VehiculoList' => 'parts/VehiculoListWidget.php',
    'VehiculoForm' => 'parts/VehiculoFormWidget.php',
    'VehiculoSearch' => 'parts/VehiculoSearchWidget.php',
    'VehiculoView' => 'parts/VehiculoViewWidget.php',

);

if (isset($files[$_GET['action']])) {
	require_once("config.inc");
	require_once $files[$_GET['action']];
} else {
	echo 'Not a valid action.';
}

?>