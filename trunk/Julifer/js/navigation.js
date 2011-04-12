function doAction(action, cmd, id) {
	if (cmd == 'delete') {
		if (!confirm('Confirme que desea borrar el elemento seleccionado')) {
			return;
		}
	}
	var url = "widget.php";

	if (action != null) {
		url += "?action=" + action;
	}
	if (cmd != null) {
		url += "&cmd=" + cmd + "&id=" + id;
	}

	$("#content").load(url);
}

function sendForm(action, cmd, id) {
	launchCursor();
	var url = "widget.php";

	if (action != null) {
		url += "?action=" + action;
	}
	if (cmd != null) {
		url += "&cmd=" + cmd + "&id=" + id;
	}

	$.post(url, $("#myForm").serialize(), function(data) {
		$('#content').html(data);
	}, "html");
	
	stopCursor();
}

/**
 * Clears a form.
 */
function resetForm() {
	$('#myForm').each(function() {
		this.reset();
	});
}

function downloadAction(action, cmd, id) {
	var url = "widget.php";

	if (action != null) {
		url += "?action=" + action;
	}
	if (cmd != null) {
		url += "&cmd=" + cmd + "&id=" + id;
	}
	
	window.open(url, '_blank');
    
	// Descargar en la misma ventana: window.location.href = url;
	// Descargar en un elemento $("#content").load(url);
}

function doActionToTarget(target, action, cmd, id) {
	var url = "widget.php";

	if (action != null) {
		url += "?action=" + action;
	}
	if (cmd != null) {
		url += "&cmd=" + cmd + "&id=" + id;
	}

	$(target).load(url);
}

/**
 * Shows an html item by its id.
 * 
 * @param id
 */
function show(idElment) {
	document.getElementById(idElment).style.display = (document
			.getElementById(idElment).style.display == 'none') ? '' : 'none';
}

/**
 * Progress launching.
 */
function launchCursor() {
	$.blockUI({ message: "<h3>Espere, por favor ...</h3>" });
	$("div.error").hide();		 	
}

/**
 * Progress stopping.
 */
function stopCursor() {
	$.unblockUI(2000);		 	
}