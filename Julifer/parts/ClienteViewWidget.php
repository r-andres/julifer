<?php
$controller = new ClienteController();
$cliente= $controller->cliente;

?>
<table id="small">
	<tbody>
		<tr>
			<th>Nombre Completo</th>
			<th>Nif</th>
		</tr>
		<tr class="odd">
			<td><?=$cliente->nombre?>&nbsp;<?=$cliente->apellidos?></td>
			<td><?=$cliente->nif?></td>
		</tr>
	</tbody>
</table>
