<?php
	$controller = new MaterialfacturadoController();
	$materialfacturado= $controller->materialfacturado;

?>
<div id="formDiv">
<form id="myForm">
<fieldset>
<legend>Materialfacturado</legend>
<p><label for="cantidad">cantidad</label> <input type="text" name="cantidad" value="<?=$materialfacturado->cantidad?>" /></p>
<p><label for="material">material</label> <input type="text" name="material" value="<?=$materialfacturado->material?>" /></p>

<input type="hidden" name="id" value="<?=$materialfacturado->id?>" />
<p class="submit"><input type="button" value="Submit" onclick="javascript:sendForm('MaterialfacturadoList','save','<?=$materialfacturado->id?>')"  /></p>
<p class="submit"><input type="button" value="Back to List" onclick="javascript:doActionToTarget('#content','MaterialfacturadoList)"  /></p>
</fieldset>
</form> 
</div>

