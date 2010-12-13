<?php

 require_once("$ROOT/lib/common/TablaCompPDF.php"); 
 require_once("$ROOT/lib/common/fpdf.php"); 
 require_once("$ROOT/lib/common/FormHelper.php"); 
 require_once("$ROOT/lib/common/IconCollection.php"); 
 require_once("$ROOT/lib/common/DBConnection.php"); 

 
 require_once("$ROOT/lib/dao/VehiculoDAO.php"); 
 require_once("$ROOT/lib/dao/FacturaDAO.php"); 
 require_once("$ROOT/lib/dao/EmpresaDAO.php"); 
 require_once("$ROOT/lib/dao/ClienteDAO.php"); 
 require_once("$ROOT/lib/dao/MaterialDAO.php"); 
 require_once("$ROOT/lib/dao/MaterialfacturadoDAO.php"); 
 
 require_once("$ROOT/lib/model/Materialfacturado.php"); 
 require_once("$ROOT/lib/model/Material.php"); 
 require_once("$ROOT/lib/model/Factura.php"); 
 require_once("$ROOT/lib/model/Vehiculo.php"); 
 require_once("$ROOT/lib/model/Cliente.php"); 
 require_once("$ROOT/lib/model/Empresa.php"); 
 
 require_once("$ROOT/lib/logic/ClienteLogic.php"); 
 require_once("$ROOT/lib/logic/MaterialfacturadoLogic.php"); 
 require_once("$ROOT/lib/logic/FacturaLogic.php"); 
 require_once("$ROOT/lib/logic/VehiculoLogic.php"); 
 require_once("$ROOT/lib/logic/MaterialLogic.php"); 
 require_once("$ROOT/lib/logic/EmpresaLogic.php"); 
 
 require_once("$ROOT/control/FacturaController.php"); 
 require_once("$ROOT/control/MaterialController.php"); 
 require_once("$ROOT/control/EmpresaController.php"); 
 require_once("$ROOT/control/ClienteController.php"); 
 require_once("$ROOT/control/MaterialfacturadoController.php"); 
 require_once("$ROOT/control/VehiculoController.php"); 
  

?>