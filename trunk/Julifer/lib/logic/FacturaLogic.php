<?php

class FacturaLogic {

	function listFacturas (&$list) {
		$dao = new FacturaDAO(db__connect());
		$list = $dao->filteredList("","");
	}

	function deleteFactura(&$factura) {
		$dao = new FacturaDAO(db__connect());
		$dao->delete($factura);
	}

	function retrieveFactura($id) {
		$dao = new FacturaDAO(db__connect());
		return $dao->get($id);
	}

	function searchFacturas(&$list, $factura, $vehiculo, $cliente) {
		$dao = new FacturaDAO(db__connect());
		$list = $dao->search($factura, $vehiculo, $cliente);
	}


	function saveFactura(&$factura) {
		$dao = new FacturaDAO(db__connect());
		$dao->save($factura);
	}
}
?>