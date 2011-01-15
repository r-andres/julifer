<?php
	$controller = new ClienteController();
?>
<fieldset>
<legend>Lista de clientes:</legend>

<table id="gradient-style">
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
		<td colspan="4"><fieldset>
			<p><label class="leftlabel">Direcci&oacute;n:</label><label class="rightlabel"><?=$cliente->direccion?></label></p>
			<p><label class="leftlabel">Nif/Cif:</label><label class="rightlabel"><?=$cliente->nif?></label></p>
			<p><label class="leftlabel">Provincia:</label><label class="rightlabel"><?=$cliente->provincia?></label></p>
			<p><label class="leftlabel">C&oacute;digo Postal:</label><label class="rightlabel"><?=$cliente->codpostal?></label></p>
			<p><label class="leftlabel">Email: </label><label class="rightlabel"><?=$cliente->correoelectronico?></label></p>
		</fieldset>
		</td>
		
		<td></td>
	</tr>
<?php  
	$counter++;
}  	 	
?>
</tbody>
</table> 
</fieldset>
