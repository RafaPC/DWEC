//function cochesYRepuestos() {

//    document.write("<a href=\"javascript:altaVehiculo()\">Alta vehículo</a>");


var arrayVehiculos = new Array();


class Repuesto {
    constructor(descripcion, pcp, pvp, meses_vida) {
        this.descripcion = descripcion;
        this.pcp = pcp;
        this.pvp = pvp;
        this.meses_vida = meses_vida;
//        this.ganancia = function ganancia() {
//            return (this.pvp - this.pcp);
//        };
    }
    
    ganancia() {
            return (this.pvp - this.pcp);
        }
        
        get meses_vida(){
            return this.meses_vida;
        }
}

class Vehiculo {
    constructor(matricula, modelo, repuestos) {
        this.matricula = matricula;
        this.modelo = modelo;
        this.respuestos = repuestos;
    }
}
arrayVehiculos.push(new Vehiculo("4BGR", "toledo", respuestos = new Array()));
do {
    var opcionV = 0;
    opcionV = parseInt(prompt("¿Qué quieres hacer?\n\
1.- Alta Vehículo\n\
2.- Facturar\n\
3.- Importe reparación\n\
4.- Ganancia taller", ""));

    switch (opcionV) {
        case 1:
            altaVehiculo();
            break;
        case 8:
            break;
    }

    function altaVehiculo() {
        var existeMatricula;
        var matricula = "";
        do {
            existeMatricula = false;
            matricula = prompt("Matrícula: ", "");
            for (var i = 0; i < arrayVehiculos.length && !existeMatricula; i++) {
                if (arrayVehiculos[i].matricula === matricula) {
                    existeMatricula = true;
                    alert("La matrícula introducida ya existe");
                }
            }

        } while (existeMatricula === true);

        var modelo = prompt("Modelo: ", "");
        var arrayRepuestos = new Array();
        var opcion = 0;
        do {
            opcion = parseInt(prompt("1.- Introducir nuevo repuesto\n\
2.- Finalizar", ""));
            if (opcion === 1) {
                var descripcion = prompt("Descripción: ", "");
                var pcpCorrecto;
                do {
                    pcpCorrecto = false;
                    var pcp = prompt("PCP: ", "");
                    var pvp = prompt("PVP: ", "");

                    if (pvp >= pcp) {
                        pcpCorrecto = true;
                    } else
                        alert("El pvp no puede ser inferior al pcp ");

                } while (pcpCorrecto === false);
                var mesesVida = 0;
                mesesVida = prompt("Meses de vida: ", 1);

                arrayRepuestos.push(new Repuesto(descripcion, pcp, pvp, mesesVida));
            } else if (opcion !== 2) {
                alert("Introduce un número válido");
            }
        } while (opcion !== 2);


        arrayVehiculos.push(new Vehiculo(matricula, modelo, arrayRepuestos));
        alert("Coche creado correctamente");
    }
} while (opcionV !== 8);

//}