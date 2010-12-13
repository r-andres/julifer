<?php
	$controller = new EmpresaController();
	$empresa= $controller->empresa;

?>
<div id="formDiv">
<form id="myForm">
<fieldset>
<legend>Empresa</legend>
<p><label for="nif">nif</label> <input type="text" name="nif" value="<?=$empresa->nif?>" /></p>
<p><label for="nombre">nombre</label> <input type="text" name="nombre" value="<?=$empresa->nombre?>" /></p>
<p><label for="direccion">direccion</label> <input type="text" name="direccion" value="<?=$empresa->direccion?>" /></p>
<p><label for="localidad">localidad</label> <input type="text" name="localidad" value="<?=$empresa->localidad?>" /></p>
<p><label for="provincia">provincia</label> <input type="text" name="provincia" value="<?=$empresa->provincia?>" /></p>
<p><label for="codpostal">codpostal</label> <input type="text" name="codpostal" value="<?=$empresa->codpostal?>" /></p>
<p><label for="telefono">telefono</label> <input type="text" name="telefono" value="<?=$empresa->telefono?>" /></p>
<p><label for="fax">fax</label> <input type="text" name="fax" value="<?=$empresa->fax?>" /></p>

<input type="hidden" name="id" value="<?=$empresa->id?>" />
<p class="submit"><input type="button" value="Submit" onclick="javascript:sendForm('EmpresaList','save','<?=$empresa->id?>')"  /></p>
<p class="submit"><input type="button" value="Back to List" onclick="javascript:doActionToTarget('#content','EmpresaList)"  /></p>
</fieldset>
</form> 
</div>

