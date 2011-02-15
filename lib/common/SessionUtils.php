<?php

class SessionUtils {

	function session_defaults() {
		$_SESSION['logged'] = false;
		$_SESSION['uid'] = 0;
		$_SESSION['username'] = '';
	}

	function setSession($values) {
		$_SESSION['uid'] = $values->id;
		$_SESSION['username'] = htmlspecialchars($values->username);
		$_SESSION['logged'] = true;
	}

	/**
	 * Checks the current session is the right one.
	 */
	function checkCurrentSession() {
		$usuario = new Usuario();
		$usuario->dump($_SESSION);

		$result = UsuarioLogic::checkSession($usuario);
		return empty($result)?false:true;
	}

	/**
	 * Updates login info based on session info.
	 */
	function updateUsernameInfo() {
	?>	
	<script>
		var url = "widget.php?action=Logout";	
		$("#login").load(url);
	</script>
	<?php 
	}

	/**
	 * Updates login info based on session info.
	 */
	function goHomePage() {
	?>	
	<script>
		$("#content").html('<img class="cover" src="images/cover.jpg" border="0"/>');
	</script>
	<?php 
	}
}
?>