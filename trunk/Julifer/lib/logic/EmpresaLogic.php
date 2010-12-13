<?php

class EmpresaLogic {

	function listEmpresas (&$list) {
		$dao = new EmpresaDAO(db__connect());
		$list = $dao->filteredList("","");
	}

	function deleteEmpresa(&$empresa) {
		$dao = new EmpresaDAO(db__connect());
		$dao->delete($empresa);
	}

	function retrieveEmpresa($id) {
		$dao = new EmpresaDAO(db__connect());
		return $dao->get($id);
	} 

	function saveEmpresa(&$empresa) {
		$dao = new EmpresaDAO(db__connect());
		$dao->save($empresa);
	}
} 
?>