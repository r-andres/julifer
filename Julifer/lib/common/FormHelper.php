<?php 

class FormHelper { 

	
	/**
	 * Creates a combo with a list of elements.
	 * 
	 * @param $label
	 * @param $name
	 * @param $listElements
	 * @param $selectedId
	 */
	function formSelectDOM  ( $label, $name, $listElements, $selectedId, $onChange ) {
	?>	
	<p><label for="<?=$name?>"><?=$label?></label>
	<?php
	   if (empty($onChange)){
	   	?>
	   	<select name="<?=$name?>" id="<?=$name?>"> 
	   	<?php
	   } else {
	?>	
	    <select name="<?=$name?>" id="<?=$name?>" onchange='javascript:<?=$onChange?>;'> 
	
	<?php 
	} 
		foreach ($listElements as $element) {
			$selected = '';
			if ($element == $selectedId ) {
				$selected = 'SELECTED';
			}
			echo ("<option value=\"$element\" $selected > " . $element . " </option>");
		}
	?>
	</select></p>		
	
<?php 
	}
	
	
	/**
	 * @param $name
	 * @param $listElements
	 * @param $selectedId
	 * @return unknown_type
	 */
	
	function formFieldDOM  ( $name, $listElements, $selectedId ) {
?>	
	<p><label for="<?=ucfirst($name)?>"><?=ucfirst($name)?></label>
	<select name="<?=$name?>" onchange="carga<?=$name?>();" id="<?=$name?>"> 
	<?php 
		foreach ($listElements as $element) {
			$selected = '';
			if ($element->id == $selectedId ) {
				$selected = 'SELECTED';
			}
			echo ("<option value=\"$element->id\" $selected > " . $element->toString() . " </option>");
		}
	?>
	</select>		
	<img id="ver<?=$name?>" src="images/go-bottom.png" border="0" />
	<img id="ocultar<?=$name?>" src="images/go-top.png" border="0" /></p>
	<div id="<?=$name?>Detalle">No disponible</div>

<?php 
	}
	
	
	
	function formFieldScript  ( $name , $widget) {
?>			
<script>
	$(document).ready(function(){

		$("#ocultar<?=$name?>").hide();
		$("#<?=$name?>Detalle").hide();
		
		$("#ver<?=$name?>" ).click(function(){
			$("#ocultar<?=$name?>").show();
			$("#ver<?=$name?>").hide();
			$("#<?=$name?>Detalle").slideDown("slow");
			
		});

		$("#ocultar<?=$name?>").click(function(){
			$("#<?=$name?>Detalle").slideUp("slow");
			$("#ocultar<?=$name?>").hide();
			$("#ver<?=$name?>").show();
			}
		);

		carga<?=$name?>();
		
	});

	function carga<?=$name?> () {
		doActionToTarget('#<?=$name?>Detalle', '<?=$widget?>' ,'edit', document.getElementById('<?=$name?>').value);
	}

	
</script>
<?php 	

	}
	
	
/**
	 * @param $name
	 * @param $element *Important* has to be defined 
	 * 					with an "id" attribute and 
	 * 					a "toString()" method 
	 * @return unknown_type
	 */
	
	function tableDataDOM  ( $name, $elementId,  $tm ) {
		$tm = "_$tm";
?>	

<td >
<img id="ver<?=$name . $tm?>" class="ver<?=$name?>" src="images/go-bottom.png" border="0"  />
<img id="ocultar<?=$name . $tm?>" class="ocultar<?=$name?>" src="images/go-top.png" border="0" style="display: none" />
<div id="<?=$name . $tm?>Detalle" class="<?=$name?>Detalle"></div>
<input type="hidden" id="<?=$name . $tm?>" value="<?=$elementId?>"/>
</td>
<?php 
	}
	
	
	
	function tableDataScript  ( $name , $widget) {
?>			
<script>
	$(document).ready(function(){

//		$(".ocultar<?=$name?>").hide();
//		$(".<?=$name?>Detalle").hide();
		
		$(".ver<?=$name?>" ).click(function(){
			var id = $(this).attr("id");
			id = id.slice(id.indexOf("_"));

						
			$("#ocultar<?=$name?>" + id ).show();
			$("#ver<?=$name?>"  + id ).hide();


			var search = $("#<?=$name?>" + id).attr("value");
			if ( $("#<?=$name?>" + id).attr("loaded") != "yes" ) {
				carga<?=$name?> (id, search);
				
			} else {
				$("#<?=$name?>"+ id + "Detalle" ).slideDown("slow");
			}
		});

		$(".ocultar<?=$name?>").click(function(){

			var id = $(this).attr("id");
			id = id.slice(id.indexOf("_") );
			
			$("#ocultar<?=$name?>" + id ).hide();
			$("#ver<?=$name?>"  + id ).show();
			$("#<?=$name?>"+ id + "Detalle" ).slideUp("slow");
			}
			
		);

		
	});


	function carga<?=$name?> (id, idBuscado) {

		var url = "widget.php?action=<?=$widget?>&cmd=edit&id=" + idBuscado;

		jQuery.ajax({
			type: "GET",
			url: url,
			success: function(data) { 
				$("#<?=$name?>"+ id + "Detalle" ).html(data);
			  	$("#<?=$name?>"+ id + "Detalle").slideDown("slow");
			  	$("#<?=$name?>" + id).attr("loaded", "yes");},
			dataType: "html"
		});
		
// 		$.get(url) {

// 			url : url,
			
// 			success : function(data) {
			  
// 			},
			
// 		});
	}
	
</script>
<?php 	

	}
	
	function euroFormat ($amount) {
		return number_format($amount, 2) . " &euro;";
	}

}
?>