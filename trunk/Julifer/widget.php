<?php

header("Content-type: text/xml");
/*** begin session ***/
session_save_path("session_tmp" ); 
session_start();

require_once("config.inc");

$action = $_GET['action'];

if ($action != 'Logout'){
	// Checking session
	$resChecking = SessionUtils::checkCurrentSession();

	if ($resChecking == false) {
		// Reseting
		SessionUtils::session_defaults();

		// open login form
		require_once 'parts/LoginWidget.php';
		exit;
	}
}

$files = array(
		    'Login' => 'parts/LoginWidget.php',
			'Logout' => 'parts/LogoutWidget.php',
		    'ClienteList' => 'parts/ClienteListWidget.php',
		    'ClienteForm' => 'parts/ClienteFormWidget.php',
		    'ClienteSearch' => 'parts/ClienteSearchWidget.php',
		    'ClienteView' => 'parts/ClienteViewWidget.php',
		    'FacturaList' => 'parts/FacturaListWidget.php',
		    'FacturaForm' => 'parts/FacturaFormWidget.php',
		    'FacturaPdf' => 'parts/FacturaPdfWidget.php',
			'FacturaSearch' => 'parts/FacturaSearchWidget.php',
			'VehiculoList' => 'parts/VehiculoListWidget.php',
		    'VehiculoForm' => 'parts/VehiculoFormWidget.php',
		    'VehiculoSearch' => 'parts/VehiculoSearchWidget.php',
		    'VehiculoView' => 'parts/VehiculoViewWidget.php',

	);
	
	if (isset($files[$action]) && !empty($files[$action])) {
		require_once $files[$_GET['action']];
	} else {
		echo 'Not a valid action.';
	}

?>