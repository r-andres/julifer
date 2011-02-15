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

	/**
	 * Performs a post filtering based on state (Pendiente-Pagado)
	 *
	 * @param $list
	 * @param $state
	 * 
	 * @return filtered facturas
	 */
	function filterFacturasByState($list, $state) {
		if ($state == 'Cualquiera') {
			return $list;
		}
		
		$newlist =  array ();
		foreach ( $list as $facturaItem) {
			if ( ($state == 'Pagado' && $facturaItem->pagado >= $facturaItem->total()) ||
			     ($state == 'Pendiente' && ($facturaItem->pagado == '' ||
			      $facturaItem->pagado < $facturaItem->total()))) {
				array_push($newlist, $facturaItem);
			}
		}
		return $newlist;
	}

	function saveFactura(&$factura) {
		$dao = new FacturaDAO(db__connect());
		$dao->save($factura);
	}
	
	/**
	 * Checks there is already a factura/presupuesto with the same number.
	 * 
	 * @param factura
	 */
	function checkUnicityFacturaWealth($factura) {
		$dao = new FacturaDAO(db__connect());
	
		$filter = "facturas.tipo='$factura->tipo' && facturas.numero=$factura->numero";
		$facturas = $dao->filteredList($filter,"");
		if (sizeof($facturas) == 0){
			return true;
		}
		
		// If the tupla tipo-number exist but is the own factura one, go on...
		return ($facturas[0]->id != 0 && $facturas[0]->id == $factura->id); 
	}
	
	/**
	 * Gets the appropriate id for facturas.
	 */
	function getNextFacturaId() {
		$dao = new FacturaDAO(db__connect());
		return $dao->getNextId(Factura::TIPO_FACTURA);
	}
	
	/**
	 * Gets the appropriate id for presupuestos.
	 */
	function getNextPresupuestoId() {
		$dao = new FacturaDAO(db__connect());
		return $dao->getNextId(Factura::TIPO_PRESUPUESTO);
	}
}
?>