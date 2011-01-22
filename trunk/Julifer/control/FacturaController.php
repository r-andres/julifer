<?php

class FacturaController {

	var $list;
	var $errs;
	var $factura;
	var $message;

	function FacturaController() {
		$action = $_GET['cmd'];
		$this->list = array();
		$this->errs = array();
		$updateList = true;
		$this->message = '';

		if ($action == 'delete') {
			// Checking the bill exists
			$this->factura = FacturaLogic::retrieveFactura($_GET['id']);
			if (empty($this->factura)){
				array_push($this->errs, "Lo sentimos, pero la factura que desea borrar no existe");
			} else {
				$factura = new  Factura();
				$factura->id =  $_GET['id'];
				FacturaLogic::deleteFactura($factura);
				$this->message = "La factura número ".$factura->id." ha sido dado borrada.";
			}
		} else if ($action == 'edit') {
			$this->factura = FacturaLogic::retrieveFactura($_GET['id']);
			$updateList = false;
		}  else if ($action == 'save') {
			$factura = new Factura();
			$factura->dump($_POST);
			FacturaLogic::saveFactura($factura);
				
			$this->message = "La factura ha sido realizada correctamente.";
		} else if ($action == 'search') {
			// Searching by client parameters
			$cliente = new Cliente();
			$cliente->dump($_POST);

			// Searching by vehicle parameters
			$vehiculo = new Vehiculo();
			$vehiculo->dump($_POST);

			// Searching by factura parameters
			$factura = new Factura();
			$factura->searchDump($_POST);
			
			FacturaLogic::searchFacturas($this->list, $factura, $vehiculo, $cliente);
			$updateList = false;
		} else if ($action == 'new') {
			$this->factura = new Factura();
			$this->factura->id = 0;
			$updateList = false;
		}

		if ($updateList) {
			FacturaLogic::listFacturas($this->list);
		}
			
	}
}
?>