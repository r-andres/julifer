<?php
class Materialfacturado {
	var $id, $cantidad, $material;
	function dump ($arr) {
		extract ($arr);
		$this->id = $id;
		$this->cantidad = $cantidad;
		$this->material = $material;
	}
}
?>