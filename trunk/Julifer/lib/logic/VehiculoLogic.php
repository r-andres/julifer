<?php

class VehiculoLogic {

	function listVehiculos (&$list) {
		$dao = new VehiculoDAO(db__connect());
		$list = $dao->filteredList("","");
	}

	 function searchVehiculos (&$list, $vehiculo, $cliente) {
		$dao = new VehiculoDAO(db__connect());
		$list = $dao->search($vehiculo, $cliente);
	}
	
	function deleteVehiculo(&$vehiculo) {
		$dao = new VehiculoDAO(db__connect());
		$dao->delete($vehiculo);
	}

	function retrieveVehiculo($id) {
		$dao = new VehiculoDAO(db__connect());
		return $dao->get($id);
	} 

	function saveVehiculo(&$vehiculo) {
		$dao = new VehiculoDAO(db__connect());
		$dao->save($vehiculo);
	}
} 
?>