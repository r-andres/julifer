<?php
	$controller = new ClienteController();
	$cliente= $controller->cliente;

?>

<script type="text/javascript" src="js/forms/cliente.js"></script>

<div id="formDiv">
<form id="myForm">
<fieldset>
<legend>Nuevo Cliente</legend>
<div class="error" style="display:none;">
 <span></span><br clear="all"/>
</div>

<p>
  <label for="nombre">Nombre</label> 
  <input type="text" name="nombre" value="<?=$cliente->nombre?>" class="required" />
</p>
<p>
  <label for="apellidos">Apellidos</label>
  <input type="text" name="apellidos" value="<?=$cliente->apellidos?>" class="required" />
</p>
<p><label for="direccion">Direcci&oacute;n</label> <input type="text" name="direccion" value="<?=$cliente->direccion?>" /></p>
<p>
  <label for="nif">Nif</label> 
  <input type="text" name="nif" value="<?=$cliente->nif?>" class="required" />
</p>
<p><label for="localidad">Localidad</label> <input type="text" name="localidad" value="<?=$cliente->localidad?>" /></p>
<p><label for="provincia">Provincia</label> <input type="text" name="provincia" value="<?=$cliente->provincia?>" /></p>
<p>
  <label for="codpostal">C&oacute;digo Postal</label> 
  <input type="text" name="codpostal" id="codpostal" class="number" value="<?=$cliente->codpostal?>" /> 
</p>
<p>
  <label for="telefono">Tel&eacute;fono</label> 
  <input type="text" name="telefono" value="<?=$cliente->telefono?>"  class="required" />
</p>
<p>
  <label for="correoelectronico">Email</label> 
  <input type="text" id="correoelectronico" name="correoelectronico" value="<?=$cliente->correoelectronico?>" class="email"/>
</p>

<input type="hidden" name="id" value="<?=$cliente->id?>" />

<p>
  <label for="buttons">&nbsp;</label>
  <input type="submit" value="Guardar" class="button" />
  <input type="button" value="Limpiar" class="button" onClick="javascript:resetForm();"/>
</p>

</fieldset>
</form> 
</div>

