<?php

class MaterialfacturadoController {

  var $list; 
  var $errs;
  var $materialfacturado;

  function MaterialfacturadoController() {
    $action = $_GET['cmd'];
    $this->list = array();
    $this->errs = array();
    $updateList = true;

    if ($action == 'delete') {
    	$materialfacturado = new  Materialfacturado();
    	$materialfacturado->id =  $_GET['id'];
    	MaterialfacturadoLogic::deleteMaterialfacturado($materialfacturado);
    	
    } else if ($action == 'edit') {
    	$this->materialfacturado = MaterialfacturadoLogic::retrieveMaterialfacturado($_GET['id']);
    	$updateList = false; 
    }  else if ($action == 'save') {
    	$materialfacturado = new Materialfacturado();
    	$materialfacturado->dump($_POST);
    	$this->cliente = MaterialfacturadoLogic::saveMaterialfacturado($materialfacturado);
    } else if ($action == 'new') {
    	$this->materialfacturado = new Materialfacturado();
    	$this->materialfacturado->id = 0;
    	$updateList = false; 
    }  
    
    
    if ($updateList) {
    	MaterialfacturadoLogic::listMaterialfacturados($this->list); 
    }
	    
  }



}
?>
