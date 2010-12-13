<?php
	$SITE = "localhost"; 
    define('SITE', $SITE); 
	
    if ($SITE == "localhost") {
		$ROOT = "/home/randres/php_workspace/Julifer";
    } else {
    	$ROOT = "/home/webcindario/x/a/xandres";
    }
    
	define('ROOT', $ROOT);
	require_once("$ROOT/lib/base.inc.php");
    
    require_once("$ROOT/control/FacturaController.php"); 
    require_once("$ROOT/control/EmpresaController.php"); 
    require_once("$ROOT/control/ClienteController.php"); 
    require_once("$ROOT/control/VehiculoController.php");

?>