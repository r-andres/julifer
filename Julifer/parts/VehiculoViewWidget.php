<?php
	$controller = new VehiculoController();
	$vehiculo= $controller->vehiculo;
	$idCliente = $vehiculo->cliente;

	$tm = time();
?>
<table id="small">
<tbody>
	<tr>
		<th>Cliente</th>
		<th>Marca</th>
		<th>Modelo</th>
	</tr>
	<tr class="odd">
		<?=FormHelper::tableDataDOM( "cliente" , $idCliente , $tm)?>
		<td ><?=$vehiculo->marca?></td>
		<td ><?=$vehiculo->modelo?></td>
	</tr>
</tbody>
</table> 
<?=FormHelper::tableDataScript("cliente", "ClienteView")?>
