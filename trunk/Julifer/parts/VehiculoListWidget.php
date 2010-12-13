<?php
	$controller = new VehiculoController();
	
?>
<table>
<tbody>
<tr>
	<th>matricula</th>
<th>marca</th>
<th>modelo</th>
<th>cliente</th>
<th>km</th>
<th>color</th>

	<th><a href="javascript:doAction('VehiculoForm','new','')"><img src="/images/add.png" /></a></th>
<?php  
	$currentTitle = "";
        $counter = 0;
	foreach ( $controller->list as $vehiculo)  {
		$tm = time() . $counter;
		$class='';
		if ($counter % 2 == 0) {
			$class = 'alt';
		}
?>
		<tr>
			<td class="<?=$class?>"><?=$vehiculo->matricula?></td>
<td class="<?=$class?>"><?=$vehiculo->marca?></td>
<td class="<?=$class?>"><?=$vehiculo->modelo?></td>
<?=FormHelper::tableDataDOM("cliente", $vehiculo->cliente, $tm)?>
<td class="<?=$class?>"><?=$vehiculo->km?></td>
<td class="<?=$class?>"><?=$vehiculo->color?></td>

			<th><a href="javascript:doAction('VehiculoList','delete','<?=$vehiculo->id?>')"><img src="/images/delete.png" /></a></th>
			<th><a href="javascript:doAction('VehiculoForm','edit','<?=$vehiculo->id?>')"><img src="/images/edit.png" /></a></th>
		</tr>
<?php  
		$counter++;
	}  
	 	
?>
</tbody>
</table> 
<?=FormHelper::tableDataScript("cliente", "ClienteView")?>
<!-- 
<script>
	$(document).ready(function(){

		$(".ocultarCliente").hide();
		$(".clienteDetalles").hide();
		
		$(".verCliente" ).click(function(){
			var id = $(this).attr("id");
			id = id.slice(id.indexOf("_") + 1);
			$("#ocultarCliente_" + id ).show();
			$("#verCliente_" + id).hide();
			var cliente = $("#cliente_" + id).attr("value");

			if ( $("#cliente_" + id).attr("loaded") != "yes" ) {
				cargaCliente (id, cliente);
				$("#cliente_" + id).attr("loaded", "yes");
			} else {
				$("#clienteDetalles_" + id).slideDown("slow");
			}
		});

		$(".ocultarCliente").click(function(){
			var id = $(this).attr("id");
			id = id.slice(id.indexOf("_") + 1);
			$("#ocultarCliente_" + id ).hide();
			$("#verCliente_" + id).show();
			$("#clienteDetalles_" + id).slideUp("slow");
			
			}
		);

		
		
	});

	function cargaCliente (id, cliente) {

		var url = "widget.php?action=ClienteView&cmd=edit&id=" + cliente;
		$.get(url, function(data) {
			  $('#clienteDetalles_' + id ).html(data);
			  $("#clienteDetalles_" + id).slideDown("slow");
		});
		
		
		
		
	}
</script>
 -->