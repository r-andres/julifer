<?php
	$controller = new FacturaController();
	$listaVehiculos = array(); 
	VehiculoLogic::listVehiculos($listaVehiculos);
	
	$listaMateriales = array(); 
	MaterialLogic::listMateriales($listaMateriales);
	
	$factura= $controller->factura;

	$fecha = $factura->fecha;
	
	if ($fecha == '') {
		$hoy = getdate();
		$fecha = $hoy['year'] . "-" .$hoy['mon'] . "-" . $hoy['mday'];
	}
	
	$listaEstados = array (Factura::TIPO_PRESUPUESTO, Factura::TIPO_FACTURA);

?>
<div id="formDiv">
<form id="myForm">
<fieldset>
<legend>Factura</legend>
<?=FormHelper::formSelectDOM("tipo","tipo", $listaEstados , $factura->tipo )?> 
<p><label for="pagado">pagado</label> <input type="text" name="pagado" value="<?=$factura->pagado?>" /></p>
<p><label for="fecha">fecha</label> <input type="text" name="fecha" value="<?=$fecha?>" /></p>
<?=FormHelper::formFieldDOM("vehiculo", $listaVehiculos , $factura->cliente )?> 
<p><label for="divMateriales">materiales</label><div id="divMateriales" name="divMateriales"/></p>
<p><label for="franquicia">franquicia</label> <input type="text" name="franquicia" value="<?=$factura->franquicia?>" /></p>
<p><label for="mecanica">mecanica</label> <textarea  name="mecanica"><?=$factura->mecanica?></textarea></p>
<p><label for="totalMecanica">total mecanica</label> <input type="text" name="totalMecanica" value="<?=$factura->totalMecanica?>" /></p>
<p><label for="descuentoMecanica">descuento mecanica</label> <input type="text" name="descuentoMecanica" value="<?=$factura->descuentoMecanica?>" /></p>
<p><label for="pintura">pintura</label> <textarea  name="pintura"><?=$factura->pintura?></textarea></p>
<p><label for="totalPintura">total pintura</label> <input type="text" name="totalPintura" value="<?=$factura->totalPintura?>" /></p>
<p><label for="descuentoPintura">descuento pintura</label> <input type="text" name="descuentoPintura" value="<?=$factura->descuentoPintura?>" /></p>
<input type="hidden" name="id" value="<?=$factura->id?>" />
<p class="submit">
	<input type="button" value="Submit" onclick="javascript:sendForm('FacturaList','save','<?=$factura->id?>')"  />
</p>
<p class="submit">
	<input type="button" value="Back to List" onclick="javascript:doActionToTarget('#content','FacturaList')"  />
</p>
</fieldset>
</form> 
</div>


<script type="text/javascript">
var rl = new RecordList(document.getElementById('divMateriales'));
<?php
if ($factura->servicios != '') {
		foreach ($factura->servicios as $servFac) {
			echo ("rl.addServicio($servFac->cantidad, '$servFac->material', $servFac->precio, $servFac->descuento);\n");
		}
}
?>
</script>
<?php
FormHelper::formFieldScript('vehiculo','VehiculoView') 
?>
