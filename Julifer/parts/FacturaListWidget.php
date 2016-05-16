<?php
	$controller = new FacturaController();
	
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
<script type="text/javascript">
if ("<?=$controller->printfactura?>") {
	downloadAction('FacturaPdf','edit','<?=$controller->factura->id?>');
}

</script>

<fieldset>
<legend>Lista de facturas:</legend>

<table>
<thead>
<tr>
    <th>&nbsp;</th>
    <th>Tipo</th>
	<th>N&uacute;mero</th>
	<th>Fecha</th>
	<th>Matr&iacute;cula</th>
	<th>Veh&iacute;culo</th>
	<th>Importe</th>
	<th>Pagado</th>
	<th>Estado</th>
	<th colspan="2">&nbsp;</th>
  </tr>
</thead>
<tbody>
<?php  
    $counter = 0;
    foreach ( $controller->list as $factura)  {
    	$tm = time() . $counter;
    	$pagado = "-";
    	$estado = "-";
    	$tipo_ab ="PREP";

    	if ($factura->tipo == Factura::TIPO_FACTURA) {
    		$tipo_ab ="FACT";
    		$pagado = FormHelper::euroFormat($factura->pagado);
    		$deuda = $factura->total() - $factura->pagado;
    		$estado = Factura::ESTADO_PAGADO;
    		if ($deuda > 0) {
    			$estado = Factura::ESTADO_PENDIENTE . " -" . FormHelper::euroFormat($deuda) ;
    		}
    	}
		
		$class='';
		if ($counter % 2 == 0) {
			$class = 'odd';
		}
?>
		<tr class="<?=$class?>">
		   <td><a href="javascript:doAction('FacturaForm','edit','<?=$factura->id?>')">
		       <img src="images/edit.png" border="0" title="Modificar Factura" /></a></td>
		   <td><?=$tipo_ab?></td>
		   <td><?=$factura->numero?></td>
		   <td><?=$factura->fecha?></td>
		   <td><?=$factura->matricula?></td>
		   <td>
		   <?=FormHelper::tableDataDOM("vehiculo", $factura->vehiculo, $tm)?>
           </td>
		<td nowrap="yes"><?=FormHelper::euroFormat($factura->total())?></td>
		<td nowrap="yes"><?=$pagado?></td>
		<td><?=$estado?></td>
		<td><a href="javascript:doAction('FacturaList','delete','<?=$factura->id?>')">
		    <img src="images/delete.png" border="0" title="Borrar Factura" /></a></td>
		<td><a href="javascript:downloadAction('FacturaPdf','edit','<?=$factura->id?>')">
		    <img src="images/printer.png" border="0" title="Generar Factura" /></a></td>
		</tr>
<?php  
		$counter++;
	}  
	 	
?>
</tbody>
</table> 

<?=FormHelper::tableDataScript("vehiculo", "VehiculoView")?>
</fieldset>

