<?php
	$controller = new MaterialfacturadoController();
?>
<table>
<tbody>
<tr>
	<th>cantidad</th>
<th>material</th>

	<th><a href="javascript:doAction('MaterialfacturadoForm','new','')"><img src="/images/edit.png" /></a></th>
<?php  
	$currentTitle = "";
        $counter = 0;
	foreach ( $controller->list as $materialfacturado)  {
		
		$class='';
		if ($counter % 2 == 0) {
			$class = 'alt';
		}
?>
		<tr>
			<td class="<?=$class?>"><?=$materialfacturado->cantidad?></td>
<td class="<?=$class?>"><?=$materialfacturado->material?></td>

			<th><a href="javascript:doAction('MaterialfacturadoList','delete','<?=$materialfacturado->id?>')"><img src="/images/delete.png" /></a></th>
			<th><a href="javascript:doAction('MaterialfacturadoForm','edit','<?=$materialfacturado->id?>')"><img src="/images/edit.png" /></a></th>
		</tr>
<?php  
		$counter++;
	}  
	 	
?>
</tbody>
</table> 

