<?php
	$controller = new MaterialController();
?>
<table>
<tbody>
<tr>
	<th>descripcion</th>
	<th>preciounitario</th>
	<th><a href="javascript:doAction('MaterialForm','new','')"><img src="/images/add.png" /></a></th>
</tr>	
<?php  
	$currentTitle = "";
        $counter = 0;
	foreach ( $controller->list as $material)  {
		
		$class='';
		if ($counter % 2 == 0) {
			$class = 'alt';
		}
?>
		<tr>
			<td class="<?=$class?>"><?=$material->descripcion?></td>
			<td class="<?=$class?>"><?=$material->preciounitario?></td>
			<th><a href="javascript:doAction('MaterialList','delete','<?=$material->id?>')"><img src="/images/delete.png" /></a></th>
			<th><a href="javascript:doAction('MaterialForm','edit','<?=$material->id?>')"><img src="/images/edit.png" /></a></th>
		</tr>
<?php  
		$counter++;
	}  
	 	
?>
</tbody>
</table> 

