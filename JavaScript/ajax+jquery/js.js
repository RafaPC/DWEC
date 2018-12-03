'use strict';

function llamada(){
	$("#imgload").css("display","block");
	var dni = $("#dni").val();
	var nombre = $("#nombre").val();
	
	
	$.ajax({
    // la URL para la petición
    url : 'http://localhost/santi/ajax/ajax+jquery/llamada_php.php',
 
    // la información a enviar
    // (también es posible utilizar una cadena de datos)
    data : { id : 123 },
 
    // especifica si será una petición POST o GET
    type : 'GET',
 
    // el tipo de información que se espera de respuesta
    dataType : 'json',
 
    // código a ejecutar si la petición es satisfactoria;
    // la respuesta es pasada como argumento a la función
    success : function(resultado) {
        //var obj = jQuery.parseJSON(resultado);
		alert('Success');
		//$("#contenido").html(obj.dni);

			},
 
    // código a ejecutar si la petición falla;
    // son pasados como argumentos a la función
    // el objeto de la petición en crudo y código de estatus de la petición
    error : function(xhr, status) {
        alert('Disculpe, existió un problema');
		$("#contenido").html("No ha encontrado nada");
    },
 
    // código a ejecutar sin importar si la petición falló o no
    complete : function(xhr, status) {
        alert('Petición realizada');
		$("#imgload").css("display","none");
    }
});
}
