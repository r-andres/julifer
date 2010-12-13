<?php
	$controller = new ClienteController();
	$cliente= $controller->cliente;

?>
<div id="formDiv">
<form id="myForm">
<fieldset>
<legend>Cliente</legend>
<p><label for="nif">nif</label> <input type="text" name="nif" value="<?=$cliente->nif?>" /></p>
<p><label for="nombre">nombre</label> <input type="text" name="nombre" value="<?=$cliente->nombre?>" /></p>
<p><label for="apellidos">apellidos</label> <input type="text" name="apellidos" value="<?=$cliente->apellidos?>" /></p>
<p><label for="direccion">direccion</label> <input type="text" name="direccion" value="<?=$cliente->direccion?>" /></p>
<p><label for="localidad">localidad</label> <input type="text" name="localidad" value="<?=$cliente->localidad?>" /></p>
<p><label for="provincia">provincia</label> <input type="text" name="provincia" value="<?=$cliente->provincia?>" /></p>
<p><label for="codpostal">codpostal</label> <input type="text" name="codpostal" value="<?=$cliente->codpostal?>" /></p>
<p><label for="telefono">telefono</label> <input type="text" name="telefono" value="<?=$cliente->telefono?>" /></p>
<p><label for="correoelectronico">correoelectronico</label> <input type="text" name="correoelectronico" value="<?=$cliente->correoelectronico?>" /></p>

<input type="hidden" name="id" value="<?=$cliente->id?>" />
<p class="submit"><input type="button" value="Submit" onclick="javascript:sendForm('ClienteList','save','<?=$cliente->id?>')"  /></p>
<p class="submit"><input type="button" value="Back to List" onclick="javascript:doActionToTarget('#content','ClienteList)"  /></p>
</fieldset>
</form> 
</div>

