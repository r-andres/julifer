<?php
class Material {
	var $id, $descripcion, $preciounitario;
	function dump ($arr) {
		extract ($arr);
		$this->id = $id;
		$this->descripcion = $descripcion;
		$this->preciounitario = $preciounitario;
	}
}
?>