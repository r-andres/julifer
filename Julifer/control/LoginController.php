<?php

class LoginController {

	var $list;
	var $errs;
	var $usuario;

	function LoginController() {
		$action = $_GET['cmd'];
		$this->list = array();
		$this->errs = array();
		$this->message = '';

		if ($action == 'login') {
			$in_usuario = new Usuario();
			$in_usuario->dump_login($_POST);
			
			$usuario = UsuarioLogic::checkLogin($in_usuario);
			if (empty($usuario)){
				array_push($this->errs, "Autentificación incorrecta, revise nick y/o clave");
			} else {
				// Setting session info 
				SessionUtils::setSession($usuario);
				
				// Update data base
				$usuario->dump_session();
				UsuarioLogic::setSession($usuario);
				$this->message = "Usuario correctamente autentificado";
				
				// Update user info
				SessionUtils::updateUsernameInfo();
				
				$_GET["action"] = $_POST['origin'];
				include 'widget.php';
				exit;
			}
		}
	}
}
?>