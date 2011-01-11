<?php

class MaterialController {

  var $list; 
  var $errs;
  var $material;

  function MaterialController() {
    $action = $_GET['cmd'];
    $this->list = array();
    $this->errs = array();
    $updateList = true;

    if ($action == 'delete') {
    	$material = new  Material();
    	$material->id =  $_GET['id'];
    	MaterialLogic::deleteMaterial($material);
    	
    } else if ($action == 'edit') {
    	$this->material = MaterialLogic::retrieveMaterial($_GET['id']);
    	$updateList = false; 
    }  else if ($action == 'save') {
    	$material = new Material();
    	$material->dump($_POST);
    	$result = MaterialLogic::saveMaterial($material);
    } else if ($action == 'new') {
    	$this->material = new Material();
    	$this->material->id = 0;
    	$updateList = false; 
    }  
    
    if (!empty($result)) {
    	array_push($this->errs,$result);
    } else {
	    if ($updateList) {
	    	MaterialLogic::listMateriales($this->list); 
	    }
    }
	    
  }



}
?>
