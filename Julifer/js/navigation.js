function doAction (action, cmd, id) {
		var url = "widget.php";

		if (action != null ) {
			url += "?action=" + action ;
		}
		if (cmd != null ) {
			url += "&cmd=" + cmd + "&id=" + id;
		}
		
		$("#content").load(url);
}

function sendForm (action, cmd, id) {
	var url = "widget.php";

	if (action != null ) {
		url += "?action=" + action ;
	}
	if (cmd != null ) {
		url += "&cmd=" + cmd + "&id=" + id;
	}
	
	
	$.post(url, $("#myForm").serialize(), function(data) {
		  $('#content').html(data);
	});
	
}

function downloadAction (action, cmd, id) {
	var url = "widget.php";

	if (action != null ) {
		url += "?action=" + action ;
	}
	if (cmd != null ) {
		url += "&cmd=" + cmd + "&id=" + id;
	}
	window.location.href = url;
	// $("#content").load(url);
}


function doActionToTarget (target, action, cmd, id) {
	var url = "widget.php";

	if (action != null ) {
		url += "?action=" + action ;
	}
	if (cmd != null ) {
		url += "&cmd=" + cmd + "&id=" + id;
	}
	
	$(target).load(url);
}
