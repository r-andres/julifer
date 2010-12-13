<?php
	$controller = new MaterialController();
	$material= $controller->material;

?>
<div id="formDiv">
<form id="myForm">
<fieldset>
<legend>Material</legend>
<p><label for="descripcion">descripcion</label> <input type="text" name="descripcion" value="<?=$material->descripcion?>" /></p>
<p><label for="preciounitario">preciounitario</label> <input type="text" name="preciounitario" value="<?=$material->preciounitario?>" /></p>

<input type="hidden" name="id" value="<?=$material->id?>" />
<p class="submit"><input type="button" value="Submit" onclick="javascript:sendForm('MaterialList','save','<?=$material->id?>')"  /></p>
<p class="submit"><input type="button" value="Back to List" onclick="javascript:doActionToTarget('#content','MaterialList)"  /></p>
</fieldset>
</form> 
</div>

