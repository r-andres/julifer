<?php

class ClienteLogic {

	function listClientes (&$list) {
		$dao = new ClienteDAO(db__connect());
		$list = $dao->filteredList("","");
	}

	function deleteCliente(&$cliente) {
		$dao = new ClienteDAO(db__connect());
		$dao->delete($cliente);
	}

	function retrieveCliente($id) {
		$dao = new ClienteDAO(db__connect());
		return $dao->get($id);
	} 

	function saveCliente(&$cliente) {
		$dao = new ClienteDAO(db__connect());
		$dao->save($cliente);
	}
} 
?>