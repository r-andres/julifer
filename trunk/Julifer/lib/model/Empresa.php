<?php
class Empresa {
	var $id, $nif, $nombre, $direccion, $localidad, $provincia, $codpostal, $telefono, $fax;
	function dump ($arr) {
		extract ($arr);
		$this->id = $id;
		$this->nif = $nif;
		$this->nombre = $nombre;
		$this->direccion = $direccion;
		$this->localidad = $localidad;
		$this->provincia = $provincia;
		$this->codpostal = $codpostal;
		$this->telefono = $telefono;
		$this->fax = $fax;
	}
}
?>