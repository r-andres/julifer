<?php




	function db__connect( )
    {
    	
    	if (SITE == "localhost") {
    		$db_server  = "localhost";
    		$db_usuario = "root";
    		$db_pass    = "brabojo";
    		$db_bbdd    = "myxmind";
    	} else {
    		$db_server  = "mysql.webcindario.com";
    		$db_usuario = "xandres";
    		$db_pass    = "WfzI8P0b9XDQ";
    		$db_bbdd    = "xandres";
    	}
    	
      	$db =mysql_connect($db_server, $db_usuario, $db_pass) or db__showError();
        $result = mysql_select_db($db_bbdd,$db);
        return $db;
    }

    function db__showError()
    {
    	echo "<h5>" .mysql_errno().": ".mysql_error()."</h5>";
    }

    function db__showErrorCause( $cause)
    {
    	echo $cause . "<br/>" .mysql_errno().": ".mysql_error()."<BR>";
    }

?>