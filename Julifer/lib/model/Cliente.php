<?php
class Cliente {
	var $id, $nif, $nombre, $apellidos, $direccion, $localidad, $provincia, $codpostal, $telefono, $correoelectronico;
	function dump ($arr) {
		extract ($arr);
		$this->id = $id;
		$this->nif = $nif;
		$this->nombre = $nombre;
		$this->apellidos = $apellidos;
		$this->direccion = $direccion;
		$this->localidad = $localidad;
		$this->provincia = $provincia;
		$this->codpostal = $codpostal;
		$this->telefono = $telefono;
		$this->correoelectronico = $correoelectronico;
	}
	
	function toString () {
		return $this->nif . " " .$this->nombre . " " . $this->apellidos ;
	}
}
?>