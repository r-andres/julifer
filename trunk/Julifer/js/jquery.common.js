$(document).ready(function(){		
    $(".resize").vjustify();
	$("div.buttonSubmit").hoverClass("buttonSubmitHover");
	
	// toggle optional billing address
	var subTableDiv = $("div.subTableDiv");
	var toggleCheck = $("input.toggleCheck");
	toggleCheck.is(":checked")
	? subTableDiv.hide()
			: subTableDiv.show();
	$("input.toggleCheck").click(function() {
		if (this.checked == true) {
			subTableDiv.slideUp("medium");
			$("form").valid();
		} else {
			subTableDiv.slideDown("medium");
		}
	});
});

$.fn.vjustify = function() {
    var maxHeight=0;
    $(".resize").css("height","auto");
    this.each(function(){
        if (this.offsetHeight > maxHeight) {
          maxHeight = this.offsetHeight;
        }
    });
    this.each(function(){
        $(this).height(maxHeight);
        if (this.offsetHeight > maxHeight) {
            $(this).height((maxHeight-(this.offsetHeight-maxHeight)));
        }
    });
};

$.fn.hoverClass = function(classname) {
	return this.hover(function() {
		$(this).addClass(classname);
	}, function() {
		$(this).removeClass(classname);
	});
};