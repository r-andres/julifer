<?php

class ClienteController {

  var $list; 
  var $errs;
  var $cliente;
  var $vehiculo;

  function ClienteController() {
    $action = $_GET['cmd'];
    $this->list = array();
    $this->errs = array();
    $updateList = true;

    if ($action == 'delete') {
    	$cliente = new  Cliente();
    	$cliente->id =  $_GET['id'];
    	ClienteLogic::deleteCliente($cliente);
    } else if ($action == 'edit') {
    	$this->cliente = ClienteLogic::retrieveCliente($_GET['id']);
    	$updateList = false; 
    }  else if ($action == 'save') {
    	$cliente = new Cliente();
    	$cliente->dump($_POST);
    	$this->cliente = ClienteLogic::saveCliente($cliente);
    } else if ($action == 'search') {
    	// Searching by client parameters
    	$cliente = new Cliente();
    	$cliente->dump($_POST);
    	
    	// Searching by vehicle parameters
    	$vehiculo = new Vehiculo();
    	$vehiculo->dump($_POST);
    	
    	ClienteLogic::searchClientes($this->list, $cliente, $vehiculo); 
    	$updateList = false; 
    } else if ($action == 'new') {
    	$this->cliente = new Cliente();
    	$this->cliente->id = 0;
    	$updateList = false; 
    }  
    
    // Showing the list of clients
    if ($updateList) {
    	ClienteLogic::listClientes($this->list); 
    }    
  }
}
?>