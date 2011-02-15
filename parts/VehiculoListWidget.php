<?php
	$controller = new VehiculoController();
	
	// Errors
	if (sizeof($controller->errs) > 0) { 
		?>
		<script language="javascript">
			alert ("<?=$controller->errs[0]?>");
		</script>
		<?php
	}
	
	// Message
	if (!empty($controller->message) > 0) { 
		?>
		<script language="javascript">
			alert ("<?=$controller->message?>");
		</script>
		<?php
	}
?>
<fieldset>
<legend>Lista de veh&iacute;culos:</legend>

<table>
<thead>
<tr>
    <th>&nbsp;</th>
	<th>Matr&iacute;cula</th>
	<th>Marca</th>
	<th>Modelo</th>
	<th>Cliente</th>
	<th>Color</th>
	<th>&nbsp;</th>
	</tr>
</thead>
<tbody>

<?php  
    $counter = 0;
	foreach ( $controller->list as $vehiculo)  {
		$idInnerTable="innerTable".$counter;
		$tm = time() . $counter;
		$class='';
		if ($counter % 2 == 0) {
			$class = 'odd';
		}
?>
		<tr class="<?=$class?>">
		  <td><a href="javascript:doAction('VehiculoForm','edit','<?=$vehiculo->id?>')">
		    <img src="images/edit.png" border="0" title="Modificar Ficha de Veh&iacute;culo" /></a></td>
		
			<td><?=$vehiculo->matricula?>
			    <a href="javascript:show('<?=$idInnerTable?>')">
			    <img src="images/cliente_more.png" border="0" title="Ver Resto de la Ficha de Veh&iacute;culo" /></a>
			</td>
		
			<td><?=$vehiculo->marca?></td>
			<td><?=$vehiculo->modelo?></td>
			<?=FormHelper::tableDataDOM("cliente", $vehiculo->cliente, $tm)?>
			<td><?=$vehiculo->color?></td>

			<td><a href="javascript:doAction('VehiculoList','delete','<?=$vehiculo->id?>')">
		    <img src="images/delete.png" border="0" title="Borrar Cliente"  /></a></td>
		</tr>
		
		<tr class="<?=$class?>" id="<?=$idInnerTable?>" style="display:none">
		<td></td>
		<td colspan="5">
		   <table id="small">
				<tr><th align="right">Número de Km:</th><td align="left"><?=$vehiculo->km?></td></tr>
				<tr><th align="right">N&uacute;mero bastidor:</th><td align="left"><?=$vehiculo->numerobastidor?></td></tr>
			</table>
		</td>
		
		<td></td>
	</tr>
<?php  
		$counter++;
	}  
	 	
?>
</tbody>
</table> 
<?=FormHelper::tableDataScript("cliente", "ClienteView")?>

</fieldset>
