<?php
	$controller = new FacturaController();
	
	// Errors
	if (sizeof($controller->errs) > 0) { 
		?>
		<script language="javascript">
			alert ("<?=$controller->errs[0]?>");
		</script>
		<?php
	}
	
	// Message
	if (!empty($controller->message) > 0) { 
		?>
		<script language="javascript">
			alert ("<?=$controller->message?>");
		</script>
		<?php
	}
?>
<script type="text/javascript">
if ("<?=$controller->printfactura?>") {
	downloadAction('FacturaPdf','edit','<?=$controller->factura->id?>');
}

</script>

<fieldset>
<legend>Lista de facturas:</legend>

<table>
<thead>
<tr>
    <th>&nbsp;</th>
	<th>Fecha</th>
	<th>Matr&iacute;cula</th>
	<th>Veh&iacute;culo</th>
	<th>Tipo</th>
	<th>Importe</th>
	<th>Pagado</th>
	<th>Estado</th>
	<th colspan="2">&nbsp;</th>
  </tr>
</thead>
<tbody>
<?php  
    $counter = 0;
    foreach ( $controller->list as $factura)  {
    	$pagado = "-";
    	$estado = "-";
    	$tipo_ab ="PREP";

    	if ($factura->tipo == Factura::TIPO_FACTURA) {
    		$tipo_ab ="FACT";
    		$pagado = FormHelper::euroFormat($factura->pagado);
    		$deuda = $factura->total() - $factura->pagado;
    		$estado = Factura::ESTADO_PAGADO;
    		if ($deuda > 0) {
    			$estado = Factura::ESTADO_PENDIENTE . " -" . FormHelper::euroFormat($deuda) ;
    		}
    	}
		
		$class='';
		if ($counter % 2 == 0) {
			$class = 'odd';
		}
?>
		<tr class="<?=$class?>">
		   <td><a href="javascript:doAction('FacturaForm','edit','<?=$factura->id?>')">
		       <img src="images/edit.png" border="0" title="Modificar Factura" /></a></td>
		   <td><?=$factura->fecha?></td>
		   <td><?=$factura->matricula?></td>
		   <td>
			<img class="verVehiculo" id="verVehiculo_<?=$counter?>" src="images/go-bottom.png" border="0" />
			<img class="ocultarVehiculo" id="ocultarVehiculo_<?=$counter?>" src="images/go-top.png" border="0" />
			<div class="vehiculoDetalles" id="vehiculoDetalles_<?=$counter?>">
			</div>
			<input type="hidden" id="vehiculo_<?=$counter?>" value="<?=$factura->vehiculo?>"/>
           </td>

		<td><?=$tipo_ab?></td>
		<td nowrap="yes"><?=FormHelper::euroFormat($factura->total())?></td>
		<td nowrap="yes"><?=$pagado?></td>
		<td><?=$estado?></td>
		<td><a href="javascript:doAction('FacturaList','delete','<?=$factura->id?>')">
		    <img src="images/delete.png" border="0" title="Borrar Factura" /></a></td>
		<td><a href="javascript:downloadAction('FacturaPdf','edit','<?=$factura->id?>')">
		    <img src="images/printer.png" border="0" title="Generar Factura" /></a></td>
		</tr>
<?php  
		$counter++;
	}  
	 	
?>
</tbody>
</table> 
</fieldset>

<script>
	$(document).ready(function(){

		$(".ocultarVehiculo").hide();
		$(".vehiculoDetalles").hide();
		
		$(".verVehiculo" ).click(function(){
			var id = $(this).attr("id");
			id = id.slice(id.indexOf("_") + 1);
			$("#ocultarVehiculo_" + id ).show();
			$("#verVehiculo_" + id).hide();
			var vehiculo = $("#vehiculo_" + id).attr("value");

			if ( $("#cliente_" + id).attr("loaded") != "yes" ) {
				cargaVehiculo (id, vehiculo);
				$("#vehiculo_" + id).attr("loaded", "yes");
			} else {
				$("#vehiculoDetalles_" + id).slideDown("slow");
			}
		});

		$(".ocultarVehiculo").click(function(){
			var id = $(this).attr("id");
			id = id.slice(id.indexOf("_") + 1);
			$("#ocultarVehiculo_" + id ).hide();
			$("#verVehiculo_" + id).show();
			$("#vehiculoDetalles_" + id).slideUp("slow");
			
			}
		);

		
		
	});

	function cargaVehiculo (id, vehiculo) {
		var url = "widget.php?action=VehiculoView&cmd=edit&id=" + vehiculo;
		$.get(url, function(data) {
			  $('#vehiculoDetalles_' + id ).html(data);
			  $("#vehiculoDetalles_" + id).slideDown("slow");
		});
	}
</script>
