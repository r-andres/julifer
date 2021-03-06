/**
 * Validates the form in client side.
 */
$(document).ready(function(){
	$numberRule = {
			regex: /^\d*\.?\d*$/
	};
	$regexMsg = {
			regex: ""
	};
	
	jQuery.validator.addMethod("regex", function( value, element, regexp ) {
		  if (regexp.constructor != RegExp)
          regexp = new RegExp(regexp);
		  else if (regexp.global)
			  regexp.lastIndex = 0;

		  return this.optional(element) || regexp.test(value);
	},  "Compruebe el formulario.");
	
	jQuery.validator.messages.required = "";
	
	$("#myForm").validate({
		invalidHandler: function(e, validator) {
		var errors = validator.numberOfInvalids();
		if (errors) {
			var message = 'Por favor, compruebe los campos se&ntilde;alados en rojo.';
			$("div.error span").html(message);
			$("div.error").show();
		} else {
			$("div.error").hide();
		}
	},
	submitHandler: function() {		 
		sendForm('FacturaList','save',$("#id").val());
	},
	onkeyup: true,
			rules: {
				pagado : $numberRule,
				numero :$numberRule,
				franquicia : $numberRule,
				totalMecanica :$numberRule,
				descuentoMecanica :$numberRule,
				totalPintura :$numberRule,
				descuentoPintura :$numberRule,
				cuentae: {
					regex: /^\d{4}$/
				},
				cuentao: {
					regex: /^\d{4}$/
				},
				cuentadc: {
					regex: /^\d{2}$/
				},
				cuentan: {
					regex: /^\d{10}$/
				}
			},
			messages: {
				pagado: $regexMsg,
				numero: $regexMsg,
				franquicia: $regexMsg,
				totalMecanica:$regexMsg,
				totalPintura:$regexMsg,
				descuentoMecanica:$regexMsg,
				cuentae: $regexMsg,
				cuentao: $regexMsg,
				cuentadc: $regexMsg,
				cuentan: $regexMsg
			},
			debug:true
	});
});

