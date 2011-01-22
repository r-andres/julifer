<?php
	$controller = new FacturaController();
	$factura= $controller->factura;
	
	$listaEstados = array (Factura::TIPO_PRESUPUESTO, Factura::TIPO_FACTURA);
?>

<div id="formDiv">
<form id="myForm">
<fieldset>
<legend>Buscar Facturas:</legend>
<?=FormHelper::formSelectDOM("tipo","tipo", $listaEstados , $factura->tipo )?> 
<p><label for="fecha">N&uacute;mero</label> <input type="text" name="fecha" value="<?=$factura->id?>" /></p>
<p><label for="fecha">Fecha</label> <input type="text" name="fecha" value="<?=$factura->fecha?>" /></p>

<p style="height:12px;"></p>

<p><label for="marca">Marca</label> <input type="text" name="marca" value="<?=$vehiculo->marca?>" /></p>
<p><label for="matricula">Matr&iacute;cula</label> <input type="text" name="matricula" value="<?=$vehiculo->matricula?>" /></p>
<p><label for="modelo">Modelo</label> <input type="text" name="modelo" value="<?=$vehiculo->modelo?>" /></p>

<p style="height:12px;"></p>

<p><label for="nombre">Nombre</label> <input type="text" name="nombre" value="<?=$cliente->nombre?>" /></p>
<p><label for="apellidos">Apellidos</label> <input type="text" name="apellidos" value="<?=$cliente->apellidos?>" /></p>

<p>
  <label for="buttons">&nbsp;</label>
  <input type="button" value="Buscar" class="button" onClick="javascript:sendForm('FacturaList','search');"/>
  <input type="button" value="Limpiar" class="button" onClick="javascript:resetForm();"/>
</p>

</fieldset>
</form> 
</div>

