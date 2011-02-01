<?php

class UsuarioLogic {
	
	function checkLogin($usuario) {
		$dao = new UsuarioDAO(db__connect());
		return $dao->checkLogin($usuario);
	}

	function checkSession($usuario) {
		$dao = new UsuarioDAO(db__connect());
		return $dao->checkSession($usuario);
	} 

	function setSession($usuario) {
		$dao = new UsuarioDAO(db__connect());
		return $dao->setSession($usuario);
	}
} 
?>