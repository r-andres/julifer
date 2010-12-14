<?php
	$SITE = "localhost"; 
    define('SITE', $SITE); 
	
    if ($SITE == "localhost") {
		$ROOT =  "C:\\Users\\monica\\workspace\\julifer";
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