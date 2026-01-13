var JsTipo      = new Array();
var JsModalidad = new Array();
var JsUnidad    = new Array();
var JsUnidadMA  = new Array();

JsTipo[0]  = ["A"	,"Agricola"];
JsTipo[1]  = ["NA"	,"No Agricola"];
JsTipo[2]  = ["NC"	,"NC"];
JsTipo[3]  = ["MS"	,"MULTISECTORIAL"];

JsModalidad[0]  = ["::"	," "];
JsModalidad[1]  = ["I"	,"Individual"];
JsModalidad[2]  = ["C"	,"Colectivo"];

JsUnidad[0]  = ["::"	," "];
JsUnidad[1]  = ["DI"	,"Dias"];
JsUnidad[2]  = ["SS"	,"Semanas"];
JsUnidad[3]  = ["MM"	,"Meses"];
JsUnidad[4]  = ["AA"	,"Años"];


JsUnidadMA[0]  = ["::"	," "];
JsUnidadMA[1]  = ["MM"	,"Meses"];
JsUnidadMA[2]  = ["AA"	,"Años"];


function validarLargoTextoN(objeto,largomax,cant_disponible){
	var comentario	= objeto.value;
	var disponibles	= largomax - comentario.length;
	if ((disponibles >= 0) && (cant_disponible!=''))
		cant_disponible.value = "" + disponibles;
	if (comentario.length > largomax)
		objeto.value = comentario.substring(0,largomax);
}

function fncGetRut(strTitulo) {
	var oData;
	var strEnlace= strNivel + 'util/busca_rut.asp';

	strEnlace += '?Titulo=' + strTitulo;
	strEnlace += '&Action=buscar';

	oData = window.showModalDialog(strEnlace, '', 'dialogWidth:500px;dialogHeight:190px; scroll:no; status:no');

	return oData;
}


function valida_keypress( textoPermitido ) {
var cont=0;

	if (event.keyCode == 40 ||  event.keyCode == 41 || event.keyCode == 43 || event.keyCode == 42 || event.keyCode == 63 || event.keyCode == 91 || event.keyCode == 93 || event.keyCode == 94 || event.keyCode == 124 || event.keyCode == 39 || event.keyCode < 32) {
		event.returnValue=false;
		return; //? 91=[ 93=] 94=^ 124=| =<>?@A34)(!"#$
	}

	var car1= String.fromCharCode( event.keyCode);

	if (car1=='.') {
		car1="\\.";
	}	

	if (textoPermitido!="")	{
		cont = textoPermitido.search(car1);
		if ( (cont == -1) || ( cont >= textoPermitido.length ) )
			event.returnValue=false;
	}
}

function valida_numero(texto) {
	// contar puntos
	var car1= String.fromCharCode( event.keyCode);

	if ( (car1=='.') || (car1=='-') )
	   {

			// Chequear Numero Negativos
			if (car1=='-')
			{
			cont = texto.value.length;
			if (cont != 0 )  // no debe haber nada para ingresar valores negativos
			    { event.returnValue=false; }
		  }
     else
     	{ 
			car1="\\.";
			cont = texto.value.search(car1);
			
			if ( (cont != -1) || texto.value=='' )
				{ event.returnValue=false; }
			}	
				
		}	
	else
		valida_keypress('-0123456789');

}


function valida_entero(texto) {
	var car1= String.fromCharCode( event.keyCode);

	if (car1=='0') {
		if (texto.value=='')
			event.returnValue=false;
	}
	else
		valida_keypress('0123456789');

}

function valida_fecha(texto) {
	var car1= String.fromCharCode( event.keyCode);
	var largo = texto.value.length;
	var agregar = '';
	var buscar='0123456879';

	if (largo>=10) {
		event.returnValue=false;
		return false;
	}

	cont = buscar.search(car1);
	
	if (cont!=-1) {
		agregar = car1;
		if ( (largo==2) || (largo==5))	
			texto.value += '-';
	}
	else
		event.returnValue=false;
}

function getPercent( porc ) {
	var barritas		= 0;
	var nobarritas		= 0;
	var strBarritas		= '';
	var strNoBarritas	= '';
	
	barritas	= (porc / 5);
	nobarritas	= (20 - barritas);
	
	for (i=1; i <= barritas; i++) {
		strBarritas += '|';
	}
	
	for (i=1; i <= nobarritas; i++) {
			strNoBarritas += '|';
	}
	
	return '<font color=#FB901D>' + strBarritas + '</font><font color=#CCCCCC>' + strNoBarritas + '</font>';
}

function fncCarga2Elementos (oSelect,ElementoSeleccionado,MatrizJs)
{
// Carga a un objeto Select (oSelect) el contenido de la matriz (Matrizjs)
// y deja selecionado un elemento (ElementoSeleccionado)

	var opcion;
	var seleccionada = -1;
	oSelect.innerHTML = '';
	
	
	for (i=0; i < MatrizJs.length  ; i++) {
		opcion = document.createElement('OPTION');
		opcion.value = MatrizJs[i][0];
		opcion.text  = MatrizJs[i][1];
		

		oSelect.options.add(opcion);

		if (ElementoSeleccionado == opcion.value)
			seleccionada = oSelect.options.length-1;
	}
	if (seleccionada >= 0)
		oSelect.options.selectedIndex = seleccionada;
	else
		oSelect.options.selectedIndex = 0;
}

function fncCargaComboConSeleccione(objeto,matriz)
{
	var opcion;
	var seleccionada = -2;
	objeto.innerHTML = '';
	opcion = document.createElement('OPTION');
	opcion.value = '-2';
	opcion.text  = '- Seleccione -';
	objeto.options.add(opcion);
	for (i=0; i < matriz.length ; i++) {
		opcion = document.createElement('OPTION');
		opcion.value = matriz[i][0];
		opcion.text  = matriz[i][1];
		objeto.options.add(opcion);
		if (objeto.value == opcion.value)
			seleccionada = objeto.options.length-1;
	}
	if (seleccionada >= 0)
		objeto.options.selectedIndex = seleccionada;
	else
		objeto.options.selectedIndex = 0;
}

function CrearJsArray(StoArray,CanElementos)
{
  // CanElementos = Entero que indica la cantidad de elmentos contando el 0
  var a = StoArray.split(":");
  var c = new Array();
  var i;
  for (i = 0; i < a.length-1; i++)
  {
    var b = a[i].split(",");
    switch (CanElementos) {
       case 1 :   
		 c[i]		= [b[0]];
		 break;
       case 2 :   
		 c[i]		= [b[0],b[1]];
		 break;
       case 3 :   
		 c[i]		= [b[0],b[1],b[2]];
		 break;
       case 4 :   
		 c[i]		= [b[0],b[1],b[2],b[3]];
		 break;
       case 5 :   
		 c[i]		= [b[0],b[1],b[2],b[3],b[4]];
		 break;
       case 6 :   
		 c[i]		= [b[0],b[1],b[2],b[3],b[4],b[5]];
		 break;
       case 7 :   
		 c[i]		= [b[0],b[1],b[2],b[3],b[4],b[5],b[6]];
		 break;
	}		 
  }
  return(c);
}

function CrearJsArrayDoble(StoArray,CanElementos)
{
  // CanElementos = Entero que indica la cantidad de elmentos contando el 0
  //alert(StoArray);
  var a = StoArray.split(":");
  var c = new Array();
  var i;
  for (i = 0; i < a.length-1; i++)
  {
    var b = a[i].split(",");
    switch (CanElementos) {
       case 1 :   
		 c[i]		= [b[0]];
		 break;
       case 2 :   
		 c[i]		= [b[0],"[" + b[0] + "] " + b[1]];
		 break;
	}		 
  }
  return(c);
}


function ValidaCaraterPegar(Cadena)
{
var i					= 0;
var caracterSeleccion	= '';
//alert('entro');
//alert(Cadena.length);
if ( Cadena.length > 0 )
   {
	for (i=0; i < Cadena.length; i++) 
	{
	    caracterSeleccion = Cadena.substr(i,1)
	    
		if (caracterSeleccion == "(" || 
		    caracterSeleccion == ")" ||
		    caracterSeleccion == "+" || 
		    caracterSeleccion == "*" ||
		    caracterSeleccion == "?" || 
		    caracterSeleccion == "¿" ||
		    caracterSeleccion == "%" ||
		    caracterSeleccion == "#" ||
		    caracterSeleccion == "&" ||
			caracterSeleccion == "'" ||
			caracterSeleccion == '"' ||
		    caracterSeleccion == "^"  )
		    {
		    return caracterSeleccion;
			//validacion = "Se  ha detectado el siguinente caracter invalido " + caracterSeleccion +", verifique.";
			}
	 }
	
	}
caracterSeleccion	= '';	
return caracterSeleccion;
}
