<?php
	$controller = new ClienteController();
	$cliente= $controller->cliente;

?>
<table>
<tbody>
<tr>
<th>nif</th>
<th>nombre</th>
<th>apellidos</th>
<th>direccion</th>
<th>localidad</th>
<!-- 
<th>provincia</th>
<th>codpostal</th>
<th>telefono</th>
<th>correoelectronico</th>
 -->
</tr>
<tr>
<td ><?=$cliente->nif?></td>
<td ><?=$cliente->nombre?></td>
<td ><?=$cliente->apellidos?></td>
<td ><?=$cliente->direccion?></td>
<td ><?=$cliente->localidad?></td>
<!--
<td ><?=$cliente->provincia?></td>
<td ><?=$cliente->codpostal?></td>
<td ><?=$cliente->telefono?></td>
<td ><?=$cliente->correoelectronico?></td>
 -->
</tr>
</tbody>
</table> 