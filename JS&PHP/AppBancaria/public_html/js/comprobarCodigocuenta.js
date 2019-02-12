/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function comprobarFormato(codCuenta) {
    var comprobacion;
    if (codCuenta.length === 10) {
        var ultimoNumero = parseInt(codCuenta.substr(9, 1));
        for (var i = 0, acum = 0; i < codCuenta.length - 1; i++) {
            acum += parseInt(codCuenta[i]);
        }
        if (acum % 9 === ultimoNumero) {
            comprobacion = 1;
        } else {
            comprobacion = -2;
        }
    } else {
        //El codigo no tiene 10 numeros
        comprobacion = -1;
    }
    return comprobacion;
}

function comprobarCodigoCuenta(codCuenta) {
    var cod_err = comprobarFormato(codCuenta);
    if (cod_err < 0) {
        handleCodCuenta(cod_err);
    } else {
        $.ajax({
            // la URL para la peticion
            url: 'php/comprobarCodigoCuenta.php',
            // la informacion a enviar
            // (tambien es posible utilizar una cadena de datos)
            data: {cod_cuenta: codCuenta},
            // especifica si sera una peticion POST o GET
            type: 'POST',
            // el tipo de informaciÃ³n que se espera de respuesta
            dataType: 'json',
            success: function (respuesta) {
                handleCodCuenta(respuesta.cod_err);
            },
            error: function (xhr, status) {
                //Error en el servidor
                handleCodCuenta(-4);
            },
            complete: function (xhr, status) {
            }
        });
    }
}

function campoCorrecto(campo) {
    //Se recibe un elemento de jQuery
    //Se coge el input de ese elemento y se le quita la clase is-invalid por si han saltado errores antes
    campo.find(":input").removeClass("is-invalid");
    //Se le añade la clase is-valid
    campo.find(":input").addClass("is-valid");
    //Se pone display:none al elemento invalid-feedback para ocultar los errores que hayan salido
    campo.find(".invalid-feedback").css("display", "none");
    //Se pone la propiedad disabled al input para que no se pueda cambiar
    campo.find(":input").prop("disabled", true);
}

function campoErroneo(campo, textoError){
    campo.find(":input").addClass("is-invalid");
    campo.find(".invalid-feedback").css("display", "block");
    campo.find(".invalid-feedback").html(textoError);
}