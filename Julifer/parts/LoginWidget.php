<?php
	$controller = new LoginController();
	$usuario= $controller->usuario;
	
	// Errors
	if (sizeof($controller->errs) > 0) { 
		?>
		<script language="javascript">
			alert ("<?=$controller->errs[0]?>");
		</script>
		<?php
	}
	
	// Message
	if (!empty($controller->message) > 0) { 
		header ("Location:");
		?>
		<script language="javascript">
			alert ("<?=$controller->message?>");
		</script>
		<?php
	}

?>

<script type="text/javascript" src="js/forms/login.js"></script>

<div id="formDiv">
<form id="myForm">
<fieldset>
<legend>Autentif&iacute;quese antes de continuar</legend>
<div class="error" style="display:none;">
 <span></span><br clear="all"/>
</div>

<p>
  <label for="nombre">Nick de Administrador</label> 
  <input type="text" name="username" value="<?=$usuario->username?>" class="required" />
</p>
<p>
  <label for="apellidos">Clave</label>
  <input type="password" name="password" value="<?=$usuario->password?>" class="required" />
</p>

<input type="hidden" name="id" value="<?=$cliente->id?>" />
<input type="hidden" name="origin" value="<?=$_GET['action']?>" />

<p>
  <label for="buttons">&nbsp;</label>
  <input type="submit" value="Autentificar" class="button" />
  <input type="button" value="Limpiar" class="button" onClick="javascript:resetForm();"/>
</p>

</fieldset>
</form> 
</div>

