<?php

class EmpresaController {

  var $list; 
  var $errs;
  var $empresa;

  function EmpresaController() {
    $action = $_GET['cmd'];
    $this->list = array();
    $this->errs = array();
    $updateList = true;

    if ($action == 'delete') {
    	$empresa = new  Empresa();
    	$empresa->id =  $_GET['id'];
    	EmpresaLogic::deleteEmpresa($empresa);
    	
    } else if ($action == 'edit') {
    	$this->empresa = EmpresaLogic::retrieveEmpresa($_GET['id']);
    	$updateList = false; 
    }  else if ($action == 'save') {
    	$empresa = new Empresa();
    	$empresa->dump($_POST);
    	$this->cliente = EmpresaLogic::saveEmpresa($empresa);
    } else if ($action == 'new') {
    	$this->empresa = new Empresa();
    	$this->empresa->id = 0;
    	$updateList = false; 
    }  
    
    
    if ($updateList) {
    	EmpresaLogic::listEmpresas($this->list); 
    }
	    
  }



}
?>