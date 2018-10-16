'use strict';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var opcion = 0;
opcion = parseInt(prompt("1.-Lo de la potencia\n\
2.-Lo de global y local\n\
3.-Cambiar el título de la página\n\
4.-Enseñar propiedades\n\
5.-Enseñar window \n\
6.-Crear persona\n\
7.-Crear personaV2\n\
8.-Algo con personas también\n\
9.-Persona y copia\n\
10.-Coche y repuestos", 1));
switch (opcion) {
    case 1:
        potencia();
        break;
    case 2:
        global();
        break;
    case 3:
        cambiarTitulo();
        break;
    case 4:
        enseñarProperties();
        break;
    case 5:
        enseñarWindow();
        break;
    case 6:
        crearPersona();
        break;
    case 7:
        crearPersonaV2();
        break;
    case 8:
        alumYPersona();
        break;
    case 9:
        personaYCopia();
        break;
    case 10:
        cochesYRepuestos();
        break;
}

function potencia() {
    var base = 0;
    var exponente = 0;
    base = parseInt(prompt("Base", 1));
    exponente = parseInt(prompt("Exponente", 1));
    alert("El resultado es " + exponencial(base, exponente));
    function exponencial(base, exponente) {
        if (exponente === 1)
            return (base);
        else
            return (base * exponencial(base, exponente - 1));
    }
}

function global() {

    var a = 7;
    alertar(a);
    function alertar() {
        var b = 2;
        var a = 1;
    }
}

function cambiarTitulo() {
    var nuevoTexto = prompt("Escribe el título", document.title);
    document.title = nuevoTexto;
}

function enseñarProperties() {
    var item;
    for (var item in document) {
        document.write(item.toString() + "<br>");
    }
}

function enseñarWindow() {
    for (var propiedad in window) {
        document.write(propiedad + ": " + window[propiedad] + "<br>");
    }
}

function crearPersona() {
    function persono(txtNombre, nEdad) {
        this.nombre = txtNombre;
        this.edad = nEdad;
        this.envejecer =
                function envejecer() {
                    this.edad += 10;
                };
    }

    var persono1 = new persono("NombreDePersona", 27);
    document.write(persona1.edad);
    persono1.envejecer();
    document.write(persona1.edad);

}

function crearPersonaV2() {
    var persona = new Object();
    persona.nombre = "Paco";
    persona.edad = 28;
    persona.envejecer = function envejecer() {
        this.edad += 10;
    };
    document.write(persona.edad);
    persona.envejecer();
    document.write(persona.edad);

}

function alumYPersona() {

    class Persona {
        constructor(nombre, edad) {
            this.nombre = nombre;
            this.edad = edad;
            this.dimeNombre = function dimeNombre() {
                return this.nombre;
            };
        }

    }

    class Alumno {
        constructor(objPersona, nota) {
            this.persona = objPersona;
            this.nota = nota;
            this.situacion = function situacion() {
                if (nota < 5) {
                    document.write("SUSPENSO");
                } else {
                    document.write("APROBADO");
                }
            };
        }
    }

    var nombre = prompt("Nombre: ", "");
    var edad = parseInt(prompt("Edad: ", "0"));
    var nota = parseInt(prompt("Nota: ", "0"));
    var persona1 = new Persona(nombre, edad);
    var alumno1 = new Alumno(persona1, nota);
    document.write(alumno1.persona.dimeNombre() + "<br>");
    alumno1.situacion();

}

function personaYCopia() {
    class Persona {
        constructor(nombre, edad) {
            this.nombre = nombre;
            this.edad = edad;

            this.copiarPersona = function (persona) {
                persona.nombre = this.nombre;
                persona.edad = this.edad;
            };
            this.toString = function () {
                document.write("Nomb re: " + this.nombre + "<br>" + "Edad: " + this.edad);
            };
        }
    }

    persona_1 = new Persona("Rafa", 18);
    persona_2 = new Persona();
    persona_1.copiarPersona(persona_2);
    persona_2.edad = 40;
    /**for(var property in persona_1){
     document.write(property + " -> " + persona_1[property] + "<br>");
     }
     for(var property in persona_2){
     document.write(property + " -> " + persona_2[property] + "<br>");
     }*/

    persona_1.toString();
    document.write("<br>");
    persona_2.toString();
}



