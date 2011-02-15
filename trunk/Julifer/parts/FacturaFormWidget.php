<?php
	$controller = new FacturaController();
	$listaVehiculos = array(); 
	VehiculoLogic::listVehiculos($listaVehiculos);
	
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
  <input class="factura" type="text" name="pagado" value="<?=$factura->pagado?>" />
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
  <input class="factura" type="text" name="franquicia" value="<?=$factura->franquicia?>" />
</p>
<p>
  <label for="mecanica">Chapa</label> 
  <textarea  name="mecanica"><?=$factura->mecanica?>
</textarea></p>
<p>
  <label for="totalMecanica">Total Chapa</label> 
  <input class="factura" type="text" name="totalMecanica" value="<?=$factura->totalMecanica?>" class="required" />
</p>
<p>
  <label for="descuentoMecanica">Descuento chapa (%)</label> 
  <input class="factura" type="text" name="descuentoMecanica" value="<?=$factura->descuentoMecanica?>" />
</p>
<p>
  <label for="pintura">Pintura</label> 
  <textarea  name="pintura"><?=$factura->pintura?></textarea>
</p>
<p>
  <label for="totalPintura">Total Pintura</label> 
  <input class="factura" type="text" name="totalPintura" value="<?=$factura->totalPintura?>"  class="required" />
</p>
<p>
  <label for="descuentoPintura">Descuento Pintura (%)</label> 
  <input class="factura" type="text" name="descuentoPintura" value="<?=$factura->descuentoPintura?>" />
</p>

<input type="hidden" name="id" value="<?=$factura->id?>" />

<p>
  <label for="buttons">&nbsp;</label>
  <input type="submit" value="Guardar" class="button" />
  <input type="button" value="Limpiar" class="button" onClick="javascript:resetForm();"/>
</p>

</fieldset>
</form> 

<div id="total"></div>
</div>


<script type="text/javascript">



function calculaFactura () {
	porcentajeIva = 18;
	totalPintura = $('input[name="totalPintura"]').val();
	totalChapa = $('input[name="totalMecanica"]').val();
	descuentoPintura = $('input[name="descuentoPintura"]').val();
	descuentoChapa = $('input[name="descuentoMecanica"]').val();
	franquicia = $('input[name="franquicia"]').val();

	if (!isNaN(descuentoPintura) ) {
		totalPintura  -= ( totalPintura * descuentoPintura) / 100; 
	}

	if (!isNaN(descuentoChapa) ) {
		totalChapa  -= ( totalChapa * descuentoChapa) / 100; 
	}

	cts = $('input[name^=cantidad]') ;

	totalMateriales = 0;
	
	for (i = 0; i < cts.length; i++) {
		ct = cts[i];
		ctName = ct.name;
		number = ctName.split("_")[1];
		cantidad = ct.value;
		preciounitario = $('input[name="precio_' + number +'"]').val();
		descuento = $('input[name="descuento_' + number +'"]').val();

		preciodescuento = preciounitario - (( preciounitario *  descuento) / 100) ;
		precio =  cantidad *  preciodescuento;
		
		totalMateriales += precio;
		
	};

	subtotal = Number(totalPintura) +  Number(totalChapa) + Number(totalMateriales);
	iva = (subtotal * porcentajeIva) / 100; 

	total = subtotal + iva;
	
	$('#total').html("<table>" +
					 "<tr><td><b>Subtotal</b></td><td>" +  formateaNumero(subtotal) + "</td></tr>" + 
					 "<tr><td><b>I.V.A. ("+ porcentajeIva + " %)</b></td><td>" +  formateaNumero(iva) + "</td></tr>" +
					 "<tr><td><b>Total</b></td><td>" + formateaNumero(total) + "</td></tr>"+
					 "<tr><td><b>Franquicia</b></td><td>" + formateaNumero(franquicia) + "</td></tr>"+
					 "<tr><td><b>Total</b></td><td>" + formateaNumero(total-franquicia) + "</td></tr>"+
					 "</table>"
			);
	
}

var rl = new RecordList(document.getElementById('divMateriales'), calculaFactura);
<?php
if ($factura->servicios != '') {
		foreach ($factura->servicios as $servFac) {
			echo ("rl.addServicio($servFac->cantidad, '$servFac->material', $servFac->precio, $servFac->descuento);\n");
		}
}
?>



function formateaNumero (original) {
	var numero = Number(original);
	var result = numero.toFixed(2);
	return result;
}

$('.factura').change(calculaFactura);
calculaFactura ();
</script>
<?php
FormHelper::formFieldScript('vehiculo','VehiculoView') 
?>
