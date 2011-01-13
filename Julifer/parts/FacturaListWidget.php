<?php
	$controller = new FacturaController();
?>
<table>
<tbody>
<tr>
<th>fecha</th>
<th>vehiculo</th>
<th>tipo</th>
<th>importe</th>
<th>pagado</th>
<th>estado</th>

	<th><a href="javascript:doAction('FacturaForm','new','')"><img src="images/add.png" /></a></th>
<?php  
	$currentTitle = "";
    $counter = 0;
   
	    
    
    
    foreach ( $controller->list as $factura)  {

    	$pagado = "-";
    	$estado = "-";

    	if ($factura->tipo == Factura::TIPO_FACTURA) {
    		$pagado = FormHelper::euroFormat($factura->pagado);
    		$deuda = $factura->total() - $factura->pagado;
    		$estado = Factura::ESTADO_PAGADO;
    		if ($deuda > 0) {
    			$estado = Factura::ESTADO_PENDIENTE . " -" . FormHelper::euroFormat($deuda) ;
    		}
    	}
		
    	
    	
		
		$class='';
		if ($counter % 2 == 0) {
			$class = 'alt';
		}
?>
		<tr>
			<td class="<?=$class?>"><?=$factura->fecha?></td>

<td class="<?=$class?>" >
<img class="verVehiculo" id="verVehiculo_<?=$counter?>" src="images/go-bottom.png" border="0" />
<img class="ocultarVehiculo" id="ocultarVehiculo_<?=$counter?>" src="images/go-top.png" border="0" />
<div class="vehiculoDetalles" id="vehiculoDetalles_<?=$counter?>">
</div>
<input type="hidden" id="vehiculo_<?=$counter?>" value="<?=$factura->vehiculo?>"/>
</td>


<td class="<?=$class?>"><?=$factura->tipo?></td>
<td nowrap="yes" class="<?=$class?>"><?=FormHelper::euroFormat($factura->total())?></td>
<td nowrap="yes" class="<?=$class?>"><?=$pagado?></td>
<td class="<?=$class?>"><?=$estado?></td>

			<th><a href="javascript:doAction('FacturaList','delete','<?=$factura->id?>')"><img src="images/delete.png" /></a></th>
			<th><a href="javascript:doAction('FacturaForm','edit','<?=$factura->id?>')"><img src="images/edit.png" /></a></th>
			<th><a href="javascript:downloadAction('FacturaPdf','edit','<?=$factura->id?>')"><img src="images/disk.png" /></a></th>
		</tr>
<?php  
		$counter++;
	}  
	 	
?>
</tbody>
</table> 
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
