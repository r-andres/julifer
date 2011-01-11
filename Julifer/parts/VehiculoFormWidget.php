<?php
	$controller = new VehiculoController();
	$vehiculo= $controller->vehiculo;

	$listaClientes = array(); 
	ClienteLogic::listClientes($listaClientes);
?>
<div id="formDiv">
<form id="myForm">
<fieldset>
<legend>Vehiculo</legend>
<p><label for="matricula">matricula</label> <input type="text" name="matricula" value="<?=$vehiculo->matricula?>" /></p>
<p><label for="marca">marca</label> <input type="text" name="marca" value="<?=$vehiculo->marca?>" /></p>
<p><label for="modelo">modelo</label> <input type="text" name="modelo" value="<?=$vehiculo->modelo?>" /></p>
<?=FormHelper::formFieldDOM("cliente", $listaClientes , $vehiculo->cliente )?> 
<p><label for="km">km</label> <input type="text" name="km" value="<?=$vehiculo->km?>" /></p>
<p><label for="color">color</label> <input type="text" name="color" value="<?=$vehiculo->color?>" /></p>
<p><label for="numerobastidor">numero bastidor</label> <input type="text" name="numerobastidor" value="<?=$vehiculo->numerobastidor?>" /></p>
<input type="hidden" name="id" value="<?=$vehiculo->id?>" />
<p class="submit"><input type="button" value="Submit" onclick="javascript:sendForm('VehiculoList','save','<?=$vehiculo->id?>')"  /></p>
<p class="submit"><input type="button" value="Back to List" onclick="javascript:doActionToTarget('#content','VehiculoList)"  /></p>
</fieldset>
</form> 
</div>
<?=FormHelper::formFieldScript("cliente", "ClienteView")?> 
