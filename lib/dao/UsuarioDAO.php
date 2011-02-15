<?php

class UsuarioDAO  {
	var $conn;
	var $TABLE_NAME = 'usuarios';

	function UsuarioDAO(&$conn) {
		$this->conn = $conn;
	}

	/**
	 * Checks username and password are valids.
	 *
	 * @param Usuario $vo
	 */
	function checkLogin($vo) {
		$password = md5($vo->password);

		$query = "SELECT * FROM  $this->TABLE_NAME WHERE ".
			"username = '$vo->username' AND " .
			"password = '$password'";
		
		$result = mysql_query($query,$this->conn) or db__showError();
		if ($myrow = mysql_fetch_array($result)) {
			do {
				$usuario = new Usuario ();
				$this->getFromResult($usuario, $myrow);
			} while ($myrow = mysql_fetch_array($result));
		}
		mysql_free_result($result);
		return $usuario;
	}

	/**
	 * Checks the session is valid.
	 * 
	 * @param Usuario $vo
	 */
	function checkSession($vo) {
		$password = md5($vo->password);

		$query = "SELECT * FROM  $this->TABLE_NAME WHERE ".
			"username = '$vo->username' AND " .
			"session = '$vo->session' AND ".
		    "ip = '$vo->ip'";

		$result = mysql_query($query,$this->conn) or db__showError();
		
		if ($myrow = mysql_fetch_array($result)) {
			do {
				$usuario = new Usuario ();
				$this->getFromResult($usuario, $myrow);
			} while ($myrow = mysql_fetch_array($result));
		}
		mysql_free_result($result);
		return $usuario;
	}

	/**
	 * Updates the session.
	 * 
	 * @param Usuario $vo
	 */
	function setSession($vo) {
		#execute update statement here
		$query = "UPDATE $this->TABLE_NAME SET session='$vo->session', ip='$vo->ip' WHERE id = '$vo->id' ";
		
		$result = mysql_query($query, $this->conn) or db__showError();
		return $result;
	}

	function getFromResult(&$vo, $result) {
		$vo->dump($result);
	}
}
?>