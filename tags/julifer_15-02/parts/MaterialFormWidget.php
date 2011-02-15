<?php
	$controller = new MaterialController();
	$material= $controller->material;

?>

<script type="text/javascript" src="js/forms/material.js"></script>

<div id="formDiv">
<form id="myForm">
<fieldset>
<legend>Material</legend>
<div class="error" style="display:none;">
 <span></span><br clear="all"/>
</div>

<p>
  <label for="descripcion">Nombre del producto</label> 
  <input type="text" id="descripcion" name="descripcion" class="required" value="<?=$material->descripcion?>" />
</p>
<p><label for="preciounitario">Precio</label> 
  <input type="text" id="preciounitario" name="preciounitario" class="required" value="<?=$material->preciounitario?>" />
</p>

<input type="hidden" name="id" id="id" value="<?=$material->id?>" />
<p class="submit">
 <input type="submit" value="Submit"  />
</p>
<!-- 
<p class="submit">
  <input type="button" value="Back to List" onclick="javascript:doActionToTarget('#content','MaterialList')"  />
</p>
 -->
</fieldset>
</form> 
</div>

