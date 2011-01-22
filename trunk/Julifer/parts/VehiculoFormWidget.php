<?php
	$controller = new VehiculoController();
	$vehiculo= $controller->vehiculo;

	$listaClientes = array(); 
	ClienteLogic::listClientes($listaClientes);
?>
<script type="text/javascript" src="js/forms/vehiculo.js"></script>

<div id="formDiv">
<form id="myForm">
<fieldset>
<legend>Ficha de Vehiculo</legend>
<div class="error" style="display:none;">
 <span></span><br clear="all"/>
</div>

<p>
  <label for="marca">Marca</label> 
  <input type="text" name="marca" value="<?=$vehiculo->marca?>" class="required" />
</p>
<p>
  <label for="modelo">Modelo</label> 
  <input type="text" name="modelo" value="<?=$vehiculo->modelo?>" class="required" />
</p>
<p>
  <label for="matricula">Matr&iacute;cula</label> 
  <input type="text" name="matricula" value="<?=$vehiculo->matricula?>" class="required" />
</p>

<?=FormHelper::formFieldDOM("cliente", $listaClientes , $vehiculo->cliente )?> 
<p><label for="km">N&uacute;mero de Km</label> <input type="text" name="km" value="<?=$vehiculo->km?>" class="number" /></p>
<p>
  <label for="color">Color</label> 
  <input type="text" name="color" value="<?=$vehiculo->color?>"  class="required" />
</p>

<p><label for="numerobastidor">N&uacute;mero de bastidor</label> <input type="text" name="numerobastidor" value="<?=$vehiculo->numerobastidor?>" /></p>
<input type="hidden" name="id" value="<?=$vehiculo->id?>" />

<p>
  <label for="buttons">&nbsp;</label>
  <input type="submit" value="Guardar" class="button" />
  <input type="button" value="Limpiar" class="button" onClick="javascript:resetForm();"/>
</p>

</fieldset>
</form> 
</div>
<?=FormHelper::formFieldScript("cliente", "ClienteView")?> 
