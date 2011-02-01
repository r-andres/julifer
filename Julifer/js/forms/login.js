/**
 * Validates the form in client side.
 */
$(document).ready(function(){		
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
		sendForm('Login', 'login');
	},
	onkeyup: true,
			rules: {
			},
			messages: {
				username: {
					required: ""
				},	
				password: {
					required: ""
				}
			},
			debug:true
	});
});

