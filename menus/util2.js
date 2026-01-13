function noselect(){ /*
	for (i=0; i<document.all.length; i++)
		document.all(i).unselectable = "on"; */
}

function derecha(e) {/*
	if (navigator.appName == 'Netscape' && (e.which == 3 || e.which == 2)){
		alert('El sistema ha bloqueado el click con el botón opuesto del ratón. Gracias por su comprensión');
		return false;
	}
	else 
		if (navigator.appName == 'Microsoft Internet Explorer' && (event.button == 2)){
			alert('El sistema ha bloqueado el click con el botón opuesto del ratón. Gracias por su comprensión');
		}*/
}

//document.onmousedown=derecha;