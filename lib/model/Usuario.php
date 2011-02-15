<?php
class Usuario {
	var $id, $username, $password, $session, $ip;

	function dump ($arr) {
		extract ($arr);
		$this->id = $id;
		$this->username = $username;
		$this->session = session_id();
		$this->ip = $_SERVER['REMOTE_ADDR'];
	}

	function dump_login ($arr) {
		extract ($arr);
		$this->username = $username;
		$this->password = $password;
	}

	function dump_session () {
		$this->session = session_id();
		$this->ip = $_SERVER['REMOTE_ADDR'];
	}
	function toString () {
		return "id: ".$this->id. ", username:  ". $this->username . ", ip: " . $this->ip . 
		", session: ". $this->session."" ;
	}
}
?>