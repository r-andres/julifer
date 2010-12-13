<?php

class VehiculoLogic {

	function listVehiculos (&$list) {
		$dao = new VehiculoDAO(db__connect());
		$list = $dao->filteredList("","");
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