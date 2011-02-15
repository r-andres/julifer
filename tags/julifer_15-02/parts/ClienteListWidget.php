<?php
	$controller = new ClienteController();
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
<legend>Lista de clientes:</legend>

<table>
<thead>
<tr>
    <th>&nbsp;</th>
	<th>Nombre</th>
	<th>Apellidos</th>
	<th>Tel&eacute;fono</th>
	<th>Localidad</th>
	 <th>&nbsp;</th>
	</tr>
</thead>
<tbody>

<?php  
    $counter = 0;
	foreach ( $controller->list as $cliente)  {		
	    $idInnerTable="innerTable".$counter;
		$class='';
		$aux = $counter % 2;
		if ($aux == 0) {
			$class = 'odd';
		}		
?>

	<tr class="<?=$class?>">
		<td><a href="javascript:doAction('ClienteForm','edit','<?=$cliente->id?>')">
		    <img src="images/edit.png" border="0" title="Modificar Ficha de Cliente" /></a></td>
		<td><?=$cliente->nombre?>
		    <a href="javascript:show('<?=$idInnerTable?>')">
		    <img src="images/cliente_more.png" border="0" title="Ver Resto de la Ficha de Cliente" /></a>
		</td>
		<td><?=$cliente->apellidos?></td>
		<td><?=$cliente->telefono?></td>
		<td><?=$cliente->localidad?></td>
		
		<td><a href="javascript:doAction('ClienteList','delete','<?=$cliente->id?>')">
		    <img src="images/delete.png" border="0" title="Borrar Cliente"  /></a></td>
	</tr>
	<tr class="<?=$class?>" id="<?=$idInnerTable?>" style="display:none">
		<td></td>
		<td colspan="4">
		    <table id="small">
				<tr><th align="right">Direcci&oacute;n:</th><td align="left"><?=$cliente->direccion?></td></tr>
				<tr><th align="right">Nif/Cif:</th><td align="left"><?=$cliente->nif?></td></tr>
				<tr><th align="right">Provincia:</th><td align="left"><?=$cliente->provincia?></td></tr>
				<tr><th align="right">C&oacute;digo Postal:</th><td align="left"><?=$cliente->codpostal?></td></tr>
				<tr><th align="right">Email:</th><td align="left"><?=$cliente->correoelectronico?></td></tr>
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

<p>
  <label for="buttons">&nbsp;</label>
  <input type="button" value="Volver" class="button" onClick="javascript:doActionToTarget('#content','ClienteSearch');"/>
</p>

</fieldset>
