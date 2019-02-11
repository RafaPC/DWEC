/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
window.onload = function(){
    $.ajax({
                // la URL para la peticion
                url: 'php/prueba.php',
                // la informacion a enviar
                // (tambien es posible utilizar una cadena de datos)
                //data: {dni: valorDNI},
                // especifica si sera una peticion POST o GET
                //type: 'POST',
                // el tipo de informaciÃ³n que se espera de respuesta
                //dataType: 'json',
                success: function (resultado) {
                    console.log(resultado);
                },
                error: function (xhr, status) {
                    alert('Disculpe, existia un problema' + status);
                },
                complete: function (xhr, status) {
                }
            });
};
