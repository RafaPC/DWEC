'use strict';
function checkCuenta() {
    var ncuenta = "" + document.getElementById('ncuenta').value;
    if (ncuenta.length !== 10) {

    } else {
        var ultimoNumero = parseInt(ncuenta.substr(9, 1));
        for (var i = 0, acum = 0; i < ncuenta.length - 1; i++) {
            acum += parseInt(ncuenta[i]);
        }
        if (acum % 9 === ultimoNumero) {
            alert(ncuenta);
			var existe = false;
                $.ajax({
                    // la URL para la peticion
                    url: 'comprobarNcuenta.php',

                    // la informacion a enviar
                    // (tambien es posible utilizar una cadena de datos)
                    data: { numCuenta: ncuenta },

                    // especifica si sera una peticion POST o GET
                    type: 'POST',

                    // el tipo de informaciÃ³n que se espera de respuesta
                    dataType: 'json',

                    // codigo a ejecutar si la peticion es satisfactoria;
                    // la respuesta es pasada como argumento a la funcion
                    success: function (resultado) {
                        if(resultado.existe){
                            existe = true;
							return true;
							}

                    },

                    // codigo a ejecutar si la peticion falla;
                    // son pasados como argumentos a la funciÃ³n
                    // el objeto de la peticion en crudo y codigo de estatus de la peticion
                    error: function (xhr, status) {
                        alert('Disculpe, existia un problema: ' + status);
						return false;
                    },

                    // codigo a ejecutar sin importar si la peticion falla o no
                    complete: function (xhr, status) {
						alert('completada');
                    }
                });
            }
            //Hacer aparecer cosas y eso
    }
}
