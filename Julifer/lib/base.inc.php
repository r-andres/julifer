<?php

 
 define("IVA", 21.0);
 error_reporting(E_ALL);

 require_once("$ROOT/lib/common/TablaCompPDF.php"); 
 require_once("$ROOT/lib/common/fpdf.php"); 
 require_once("$ROOT/lib/common/FormHelper.php"); 
 require_once("$ROOT/lib/common/IconCollection.php"); 
 require_once("$ROOT/lib/common/DBConnection.php"); 
 require_once("$ROOT/lib/common/SessionUtils.php");
 
 require_once("$ROOT/lib/dao/VehiculoDAO.php"); 
 require_once("$ROOT/lib/dao/FacturaDAO.php"); 
 require_once("$ROOT/lib/dao/ClienteDAO.php"); 
 require_once("$ROOT/lib/dao/MaterialfacturadoDAO.php"); 
 require_once("$ROOT/lib/dao/UsuarioDAO.php"); 
  
 require_once("$ROOT/lib/model/Materialfacturado.php"); 
 require_once("$ROOT/lib/model/Factura.php"); 
 require_once("$ROOT/lib/model/Vehiculo.php"); 
 require_once("$ROOT/lib/model/Cliente.php"); 
 require_once("$ROOT/lib/model/Empresa.php"); 
 require_once("$ROOT/lib/model/Usuario.php"); 
  
 require_once("$ROOT/lib/logic/ClienteLogic.php"); 
 require_once("$ROOT/lib/logic/MaterialfacturadoLogic.php"); 
 require_once("$ROOT/lib/logic/FacturaLogic.php"); 
 require_once("$ROOT/lib/logic/VehiculoLogic.php"); 
 require_once("$ROOT/lib/logic/UsuarioLogic.php"); 
  
 require_once("$ROOT/control/FacturaController.php"); 
 require_once("$ROOT/control/ClienteController.php"); 
 require_once("$ROOT/control/LogoutController.php"); 
 require_once("$ROOT/control/MaterialfacturadoController.php"); 
 require_once("$ROOT/control/VehiculoController.php"); 
 require_once("$ROOT/control/LoginController.php");   

?>