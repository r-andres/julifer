<?php
class Materialfacturado {
	var $id, $cantidad, $material, $precio, $descuento;
	function dump ($arr) {
		extract ($arr);
		$this->id = $id;
		$this->cantidad = $cantidad;
		$this->material = $material;
		$this->precio = $precio;
		$this->descuento = $descuento;
	}
}
?>