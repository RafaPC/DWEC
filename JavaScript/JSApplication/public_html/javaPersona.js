'use strict';
class Persona {
    constructor(nombre, direccion) {
        this.nombre = nombre;
        this.direccion = direccion;
    }
    
    imprimirDatos() {
            document.write("Nombre: " + this.nombre);
            document.write("Dirección: " + this.direccion);
        };
}

class Calificaciones{
    constructor(asignatura, nota){
       this.asignatura = asignatura;
       this.nota = nota;
    }
    
    imprimirDatos() {
            document.write("Asignatura: " + this.asignatura);
            document.write("Nota: " + this.nota);
        };
}


class Alumno {
    constructor(persona, longitudCal, grupo) {
        this.persona = persona;
        this.arrayCal = new Array[longitudCal];
        this.grupo = grupo;
        this.notaMedia = function notaMedia(){
            
        };
        this.aprobado = function aprobado(){
          var aprobado = false;
            if(this.notaMedia()>=5)
              aprobado = true;
         
          return aprobado;
        };
    }

}

