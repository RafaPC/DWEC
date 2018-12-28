'use strict';

function llamada(){
	$("#imgload").css("display","block");
	var dni = $("#dni").val();
	var nombre = $("#nombre").val();
	
	
	$.ajax({
    // la URL para la peticion
    url : 'http://localhost/santi/ajax/ajax+jquery/llamada_php.php',
 
    // la informacion a enviar
    // (tambien es posible utilizar una cadena de datos)
    data : { id : 123 },
 
    // especifica si sera una peticion POST o GET
    type : 'GET',
 
    // el tipo de información que se espera de respuesta
    dataType : 'json',
 
    // codigo a ejecutar si la peticion es satisfactoria;
    // la respuesta es pasada como argumento a la funcion
    success : function(resultado) {
        //var obj = jQuery.parseJSON(resultado);
		alert('Success');
		//$("#contenido").html(obj.dni);

			},
 
    // codigo a ejecutar si la peticion falla;
    // son pasados como argumentos a la función
    // el objeto de la peticion en crudo y codigo de estatus de la peticion
    error : function(xhr, status) {
        alert('Disculpe, existia un problema');
		$("#contenido").html("No ha encontrado nada");
    },
 
    // codigo a ejecutar sin importar si la peticion falla o no
    complete : function(xhr, status) {
        alert('Peticion realizada');
		$("#imgload").css("display","none");
    }
});
}
