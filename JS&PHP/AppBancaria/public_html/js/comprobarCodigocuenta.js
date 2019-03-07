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
        setCarga();
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
                //Error de conexión al servidor
                handleCodCuenta(-7);
            },
            complete: function (xhr, status) {
                unsetCarga();
            }
        });
    }
}