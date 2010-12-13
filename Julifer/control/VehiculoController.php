<?php

class VehiculoController {

  var $list; 
  var $errs;
  var $vehiculo;

  function VehiculoController() {
    $action = $_GET['cmd'];
    $this->list = array();
    $this->errs = array();
    $updateList = true;

    if ($action == 'delete') {
    	$vehiculo = new  Vehiculo();
    	$vehiculo->id =  $_GET['id'];
    	VehiculoLogic::deleteVehiculo($vehiculo);
    	
    } else if ($action == 'edit') {
    	$this->vehiculo = VehiculoLogic::retrieveVehiculo($_GET['id']);
    	$updateList = false; 
    }  else if ($action == 'save') {
    	$vehiculo = new Vehiculo();
    	$vehiculo->dump($_POST);
    	$this->cliente = VehiculoLogic::saveVehiculo($vehiculo);
    } else if ($action == 'new') {
    	$this->vehiculo = new Vehiculo();
    	$this->vehiculo->id = 0;
    	$updateList = false; 
    }  
    
    
    if ($updateList) {
    	VehiculoLogic::listVehiculos($this->list); 
    }
	    
  }



}
?>