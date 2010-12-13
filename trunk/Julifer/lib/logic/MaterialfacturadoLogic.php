<?php

class MaterialfacturadoLogic {

	function listMaterialfacturados (&$list) {
		$dao = new MaterialfacturadoDAO(db__connect());
		$list = $dao->filteredList("","");
	}

	function deleteMaterialfacturado(&$materialfacturado) {
		$dao = new MaterialfacturadoDAO(db__connect());
		$dao->delete($materialfacturado);
	}

	function retrieveMaterialfacturado($id) {
		$dao = new MaterialfacturadoDAO(db__connect());
		return $dao->get($id);
	} 

	function saveMaterialfacturado(&$materialfacturado) {
		$dao = new MaterialfacturadoDAO(db__connect());
		$dao->save($materialfacturado);
	}
} 
?>