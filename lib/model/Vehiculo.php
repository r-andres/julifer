<?php
class Vehiculo {
	var $id, $matricula, $marca, $modelo, $cliente, $km, $color, $numerobastidor;
	function dump ($arr) {
		extract ($arr);
		$this->id = $id;
		$this->matricula = $matricula;
		$this->marca = $marca;
		$this->modelo = $modelo;
		$this->cliente = $cliente;
		$this->km = $km;
		$this->color = $color;
		$this->numerobastidor = $numerobastidor;
	}
	
	function toString () {
		return $this->matricula;
	}
}
?>