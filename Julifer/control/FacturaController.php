<?php

class FacturaController {

  var $list; 
  var $errs;
  var $factura;

  function FacturaController() {
    $action = $_GET['cmd'];
    $this->list = array();
    $this->errs = array();
    $updateList = true;

    if ($action == 'delete') {
    	$factura = new  Factura();
    	$factura->id =  $_GET['id'];
    	FacturaLogic::deleteFactura($factura);
    } else if ($action == 'edit') {
    	$this->factura = FacturaLogic::retrieveFactura($_GET['id']);
    	$updateList = false; 
    }  else if ($action == 'save') {
    	$factura = new Factura();
    	$factura->dump($_POST);
    	$this->cliente = FacturaLogic::saveFactura($factura);
    } else if ($action == 'new') {
    	$this->factura = new Factura();
    	$this->factura->id = 0;
    	$updateList = false; 
    }  
    
    if ($updateList) {
    	FacturaLogic::listFacturas($this->list); 
    }
	    
  }
}
?>