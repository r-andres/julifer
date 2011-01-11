<?php

class MaterialLogic {

	function listMateriales (&$list) {
		$dao = new MaterialDAO(db__connect());
		$list = $dao->filteredList("","");
	}

	function deleteMaterial(&$material) {
		$dao = new MaterialDAO(db__connect());
		$dao->delete($material);
	}

	function retrieveMaterial($id) {
		$dao = new MaterialDAO(db__connect());
		return $dao->get($id);
	} 

	function saveMaterial(&$material) {
		$dao = new MaterialDAO(db__connect());
		return $dao->save($material);
	}
} 
?>