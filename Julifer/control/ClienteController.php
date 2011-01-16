<?php

class ClienteController {

	var $list;
	var $errs;
	var $cliente;
	var $vehiculo;
	var $message;

	function ClienteController() {
		$action = $_GET['cmd'];
		$this->list = array();
		$this->errs = array();
		$updateList = true;
		$message = "";

		if ($action == 'delete') {
			// Checking the user exists
			$this->cliente = ClienteLogic::retrieveCliente($_GET['id']);
			if (empty($this->cliente)){
				array_push($this->errs, "Lo sentimos, pero el cliente que desea borrar no existe");
			} else {
				// Deleting the client
				$cliente = new Cliente();
				$cliente->id =  $_GET['id'];
				ClienteLogic::deleteCliente($cliente);
			}
		} else if ($action == 'edit') {
			$this->cliente = ClienteLogic::retrieveCliente($_GET['id']);
			$updateList = false;
		}  else if ($action == 'save') {
			// Checking the client does not exist in the data base
			$auxcliente = new Cliente();
			$auxcliente->nif = $_POST['nif'];
			ClienteLogic::searchClientes($this->list2, $auxcliente,  array());
			if (sizeof($this->list2)>0) {
				array_push($this->errs,
				"Lo sentimos, pero ya hay un cliente con ese cif/nif");
			} else {
				$cliente = new Cliente();
				$cliente->dump($_POST);
				$this->cliente = ClienteLogic::saveCliente($cliente);
				$message = "El cliente" + $cliente->nombre + " ha sido dado de alta en el sistema.";
			}
		} else if ($action == 'search') {
			// Searching by client parameters
			$cliente = new Cliente();
			$cliente->dump($_POST);

			// Searching by vehicle parameters
			$vehiculo = new Vehiculo();
			$vehiculo->dump($_POST);

			ClienteLogic::searchClientes($this->list, $cliente, $vehiculo);
			$updateList = false;
		} else if ($action == 'new') {
			$this->cliente = new Cliente();
			$this->cliente->id = 0;
			$updateList = false;
		}

		// Showing the list of clients
		if ($updateList) {
			ClienteLogic::listClientes($this->list);
		}
	}
}
?>