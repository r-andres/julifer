<?php

class VehiculoController {

	var $list;
	var $errs;
	var $vehiculo;
	var $message;

	function VehiculoController() {
		$action = $_GET['cmd'];
		$this->list = array();
		$this->errs = array();
		$this->message = '';
		$updateList = true;

		if ($action == 'delete') {
			// Checking the vehicle exists
			$this->vehiculo = VehiculoLogic::retrieveVehiculo($_GET['id']);
			if (empty($this->vehiculo)){
				array_push($this->errs, "Lo sentimos, pero el vehiculo que desea borrar no existe");
			} else {
				$vehiculo = new  Vehiculo();
				$vehiculo->id =  $_GET['id'];
				VehiculoLogic::deleteVehiculo($vehiculo);
				$this->message = "El vehiculo con matricula ".$vehiculo->matricula." ha sido dado de baja en el sistema.";
			}
		} else if ($action == 'edit') {
			$this->vehiculo = VehiculoLogic::retrieveVehiculo($_GET['id']);
			$updateList = false;
		}  else if ($action == 'save') {
			$vehiculo = new Vehiculo();
			$vehiculo->dump($_POST);

			$alta = false;
			// New vehicle: Checking the vehicle does not exist in the data base
			if ($vehiculo->id == 0) {
				// Checking the vehicle does not exist in the data base
				$auxvehicle = new Vehiculo();
				$auxvehicle->matricula = $_POST['matricula'];
				VehiculoLogic::searchVehiculos($this->list2, $auxvehicle,  array());
				if (sizeof($this->list2)>0) {
					array_push($this->errs, "Lo sentimos, pero ya hay un vehiculo con esa matrícula");
				}
				$alta = true;
			}
			// No erros.. go on
			if (sizeof($this->errs) == 0) {
				$this->cliente = VehiculoLogic::saveVehiculo($vehiculo);
				$this->message = "El vehiculo con matricula ".
				$vehiculo->matricula.($alta?" ha sido dado de alta en el sistema.":" ha sido modificado correctamente.");
			}
		} else if ($action == 'search') {
			// Searching by client parameters
			$cliente = new Cliente();
			$cliente->dump($_POST);

			// Searching by vehicle parameters
			$vehiculo = new Vehiculo();
			$vehiculo->dump($_POST);

			VehiculoLogic::searchVehiculos($this->list, $vehiculo, $cliente);
			$updateList = false;
		} else if ($action == 'new') {
			$this->vehiculo = new Vehiculo();
			$this->vehiculo->id = 0;
			$updateList = false;
		}


		if ($updateList) {
			VehiculoLogic::listVehiculos($this->list);
		}
	}
}
?>