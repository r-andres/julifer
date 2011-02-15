<?php
	$controller = new ClienteController();
	$cliente= $controller->cliente;

?>
<div id="formDiv">
<form id="myForm">
<fieldset>
<legend>Buscar clientes:</legend>
<p><label for="nif">Nif/Cif</label> <input type="text" name="nif" value="<?=$cliente->nif?>" /></p>
<p><label for="nombre">Nombre</label> <input type="text" name="nombre" value="<?=$cliente->nombre?>" /></p>
<p><label for="apellidos">Apellidos</label> <input type="text" name="apellidos" value="<?=$cliente->apellidos?>" /></p>

<p style="height:12px;"></p>

<p><label for="marca">Marca</label> <input type="text" name="marca" value="<?=$vehiculo->marca?>" /></p>
<p><label for="matricula">Matr&iacute;cula</label> <input type="text" name="matricula" value="<?=$vehiculo->matricula?>" /></p>
<p><label for="modelo">Modelo</label> <input type="text" name="modelo" value="<?=$vehiculo->modelo?>" /></p>
<p><label for="color">Color</label> <input type="text" name="color" value="<?=$vehiculo->color?>" /></p>

<p>
  <label for="buttons">&nbsp;</label>
  <input type="button" value="Buscar" class="button" onClick="javascript:sendForm('ClienteList','search');"/>
  <input type="button" value="Limpiar" class="button" onClick="javascript:resetForm();"/>
</p>

</fieldset>
</form> 
</div>

