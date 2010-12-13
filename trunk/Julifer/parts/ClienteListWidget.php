<?php
	$controller = new ClienteController();
?>
<table>
<tbody>
<tr>
	<th>nif</th>
<th>nombre</th>
<th>apellidos</th>
<th>direccion</th>
<th>localidad</th>
<th>provincia</th>
<th>codpostal</th>
<th>telefono</th>
<th>correoelectronico</th>

	<th><a href="javascript:doAction('ClienteForm','new','')"><img src="/images/add.png" /></a></th>
<?php  
	$currentTitle = "";
        $counter = 0;
	foreach ( $controller->list as $cliente)  {
		
		$class='';
		if ($counter % 2 == 0) {
			$class = 'alt';
		}
?>
		<tr>
			<td class="<?=$class?>"><?=$cliente->nif?></td>
<td class="<?=$class?>"><?=$cliente->nombre?></td>
<td class="<?=$class?>"><?=$cliente->apellidos?></td>
<td class="<?=$class?>"><?=$cliente->direccion?></td>
<td class="<?=$class?>"><?=$cliente->localidad?></td>
<td class="<?=$class?>"><?=$cliente->provincia?></td>
<td class="<?=$class?>"><?=$cliente->codpostal?></td>
<td class="<?=$class?>"><?=$cliente->telefono?></td>
<td class="<?=$class?>"><?=$cliente->correoelectronico?></td>

			<th><a href="javascript:doAction('ClienteList','delete','<?=$cliente->id?>')"><img src="/images/delete.png" /></a></th>
			<th><a href="javascript:doAction('ClienteForm','edit','<?=$cliente->id?>')"><img src="/images/edit.png" /></a></th>
		</tr>
<?php  
		$counter++;
	}  
	 	
?>
</tbody>
</table> 

