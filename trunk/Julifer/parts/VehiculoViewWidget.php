<?php
	$controller = new VehiculoController();
	$vehiculo= $controller->vehiculo;
	$idCliente = $vehiculo->cliente;
//	$cliente= ClienteLogic::retrieveCliente($idCliente);

	$tm = time();
?>
<table>
<tbody>
<tr>
<th>matricula</th>
<th>cliente</th>
<th>marca</th>
<th>modelo</th>
<!-- 
<th>km</th>
<th>color</th>
-->
</tr>
<tr>
<td ><?=$vehiculo->matricula?></td>
<?=FormHelper::tableDataDOM( "cliente" , $idCliente , $tm)?>
<td ><?=$vehiculo->marca?></td>
<td ><?=$vehiculo->modelo?></td>
<!-- 
<td ><?=$vehiculo->km?></td>
<td ><?=$vehiculo->color?></td>
 -->
</tr>
</tbody>
</table> 
<?=FormHelper::tableDataScript("cliente", "ClienteView")?>
