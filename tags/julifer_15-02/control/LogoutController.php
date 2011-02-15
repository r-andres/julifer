<?php

class LogoutController {

	var $username;

	function LogoutController() {
		$action = $_GET['cmd'];

		if ($action == 'logout') {
		    // Reseting
  			SessionUtils::session_defaults();

  			// Home page
  			SessionUtils::goHomePage();
  			exit;
		} else {
			$resChecking = SessionUtils::checkCurrentSession();
			if ($resChecking == true) {
				$this->username = $_SESSION['username'];	
			}
		}
	}
}
?>