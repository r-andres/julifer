<?php

class FacturaController {

	var $list;
	var $errs;
	var $factura;
	var $message;
	var $idfactura;
	var $idpresupuesto;
	var $printfactura;

	function FacturaController() {
		$action = $_GET['cmd'];
		$this->list = array();
		$this->errs = array();
		$updateList = true;
		$this->message = '';
		$this->printfactura = false;
		
		if ($action == 'delete') {
			// Checking the bill exists
			$this->factura = FacturaLogic::retrieveFactura($_GET['id']);
			if (empty($this->factura)){
				array_push($this->errs, "Lo sentimos, pero la factura que desea borrar no existe");
			} else {
				$factura = new  Factura();
				$factura->id =  $_GET['id'];
				FacturaLogic::deleteFactura($factura);
				$this->message = "La factura/presupuesto ha sido eliminada/o.";
			}
		} else if ($action == 'edit') {
			$this->factura = FacturaLogic::retrieveFactura($_GET['id']);
			
			// Numero for presupuesto/factura
			if ($this->factura->tipo == 'FACTURA'){
				$this->idfactura =$this->factura->numero;
				$this->idpresupuesto = FacturaLogic::getNextPresupuestoId();
			} else {
				$this->idfactura = FacturaLogic::getNextFacturaId();
				$this->idpresupuesto = $this->factura->numero;
			}
			
			$updateList = false;
		}  else if ($action == 'save') {
			$factura = new Factura();
			$factura->dump($_POST);
			$newfactura = ($factura->id == 0);
			
			// Checking unicity of tupla tipo-numero
			if (!FacturaLogic::checkUnicityFacturaWealth($factura)) {
				array_push($this->errs, "Lo sentimos, pero ya existe una factura/presupuesto con ese numero");
			} else {
				FacturaLogic::saveFactura($factura);
				$this->message = "La factura ha sido ".($newfactura?"realizada":"modificada"). " correctamente";
				$this->printfactura = true;
				$this->factura = $factura;
			}
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
			
			// Postfiltering by state
			$this->list = FacturaLogic::filterFacturasByState($this->list, $_POST['estado']);
			
			$updateList = false;
		} else if ($action == 'new') {
			$this->factura = new Factura();
			$this->factura->id = 0;
			$this->idfactura = FacturaLogic::getNextFacturaId();
			$this->idpresupuesto = FacturaLogic::getNextPresupuestoId();
			$this->factura->numero = $this->idfactura;
			$updateList = false;
		}

		if ($updateList) {
			FacturaLogic::listFacturas($this->list);
		}
	}
}
?>