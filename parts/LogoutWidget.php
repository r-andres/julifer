<?php

$controller = new LogoutController();
$username = $controller->username;

if (!empty($username)) {
	?>
<script>
  function doLogout() {
	  if (confirm("Confirme que realmente desea dejar la aplicación.")) {
		  doActionToTarget('#login','Logout', 'logout');
	}  
  }
</script>
	Hola, <?=$username?>&nbsp;
	<a href="javascript:doLogout();"> 
	<img src="images/exit.png" border="0" title="Salir"  class="textmiddle" /></a>
<?php	
	}
?>

