<?php
	$controller = new EmpresaController();
?>
<table>
<tbody>
<tr>
	<th>nif</th>
<th>nombre</th>
<th>direccion</th>
<th>localidad</th>
<th>provincia</th>
<th>codpostal</th>
<th>telefono</th>
<th>fax</th>

	<th><a href="javascript:doAction('EmpresaForm','new','')"><img src="/images/edit.png" /></a></th>
<?php  
	$currentTitle = "";
        $counter = 0;
	foreach ( $controller->list as $empresa)  {
		
		$class='';
		if ($counter % 2 == 0) {
			$class = 'alt';
		}
?>
		<tr>
			<td class="<?=$class?>"><?=$empresa->nif?></td>
<td class="<?=$class?>"><?=$empresa->nombre?></td>
<td class="<?=$class?>"><?=$empresa->direccion?></td>
<td class="<?=$class?>"><?=$empresa->localidad?></td>
<td class="<?=$class?>"><?=$empresa->provincia?></td>
<td class="<?=$class?>"><?=$empresa->codpostal?></td>
<td class="<?=$class?>"><?=$empresa->telefono?></td>
<td class="<?=$class?>"><?=$empresa->fax?></td>

			<th><a href="javascript:doAction('EmpresaList','delete','<?=$empresa->id?>')"><img src="/images/delete.png" /></a></th>
			<th><a href="javascript:doAction('EmpresaForm','edit','<?=$empresa->id?>')"><img src="/images/edit.png" /></a></th>
		</tr>
<?php  
		$counter++;
	}  
	 	
?>
</tbody>
</table> 

