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
		$fecha = $hoy['mday']. "-".$hoy['mon']."-".$hoy['year'];
	}
	
	$listaEstados = array ( Factura::TIPO_FACTURA, Factura::TIPO_PRESUPUESTO);

?>
<script type="text/javascript" src="js/forms/factura.js"></script>

<div id="formDiv">
<form id="myForm">
<fieldset>
<legend>Factura/Presupuesto</legend>
<div class="error" style="display:none;">
 <span></span><br clear="all"/>
</div>

<?=FormHelper::formSelectDOM("Tipo","tipo", $listaEstados , $factura->tipo )?> 
<p>
  <label for="pagado">Pagado</label>
  <input type="text" name="pagado" value="<?=$factura->pagado?>" />
</p>
<p>
  <label for="fecha">Fecha (dd-mm-yyyy)</label> 
  <input type="text" name="fecha" value="<?=$fecha?>" />
</p>
<?=FormHelper::formFieldDOM("vehiculo", $listaVehiculos , $factura->vehiculo )?> 

<p>
  <label for="divMateriales">Materiales</label>
  <div id="divMateriales" name="divMateriales" />
</p>
<p>
  <label for="franquicia">Franquicia</label> 
  <input type="text" name="franquicia" value="<?=$factura->franquicia?>" />
</p>
<p>
  <label for="mecanica">Chapa</label> 
  <textarea  name="mecanica"><?=$factura->mecanica?>
</textarea></p>
<p>
  <label for="totalMecanica">Total Chapa</label> 
  <input type="text" name="totalMecanica" value="<?=$factura->totalMecanica?>" class="required" />
</p>
<p>
  <label for="descuentoMecanica">Descuento chapa (%)</label> 
  <input type="text" name="descuentoMecanica" value="<?=$factura->descuentoMecanica?>" />
</p>
<p>
  <label for="pintura">Pintura</label> 
  <textarea  name="pintura"><?=$factura->pintura?></textarea>
</p>
<p>
  <label for="totalPintura">Total Pintura</label> 
  <input type="text" name="totalPintura" value="<?=$factura->totalPintura?>"  class="required" />
</p>
<p>
  <label for="descuentoPintura">Descuento Pintura (%)</label> 
  <input type="text" name="descuentoPintura" value="<?=$factura->descuentoPintura?>" />
</p>

<input type="hidden" name="id" value="<?=$factura->id?>" />

<p>
  <label for="buttons">&nbsp;</label>
  <input type="submit" value="Guardar" class="button" />
  <input type="button" value="Limpiar" class="button" onClick="javascript:resetForm();"/>
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
