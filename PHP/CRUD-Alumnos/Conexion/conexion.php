<?php

class Singleton {

    private $Idb;
    private $filas = array();
    private static $instancia; // contenedor de la instancia

    private function __construct() { //método singleton que crea instancia sí no está creada
        $this->Idb = new PDO('mysql:host=localhost;dbname=crud;charset=UTF8', 'root', '1234');
    }

    public static function getConex() { //método singleton que crea instancia sí no está creada
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }

    public function __clone() { // Evita que el objeto se pueda clonar
        trigger_error('La clonación de este objeto no está permitida', E_USER_ERROR);
    }

    public function getAllFromX($x) {
        try {
            $q = $this->Idb->query("SELECT * FROM $x");
            $filas = array();
            $q->setFetchMode(PDO::FETCH_ASSOC);
            while ($r = $q->fetch()) {
                $filas[] = $r;
            }
            return $filas;
        } catch (PDOException $e) {
            echo ( "¡Error! al ejecutar consulta: " . $e->getMessage() . "<br/>");
            return false;
        }
    }

    public function getAlumnoOrClase($tabla, $id) {
        try {
            $q = $this->Idb->query("SELECT * FROM $tabla WHERE ID ='$id'");
            $q->setFetchMode(PDO::FETCH_ASSOC);
            $filas = $q->fetchAll();
            return $filas[0];
        } catch (PDOException $e) {
            echo ( "¡Error! al ejecutar consulta: " . $e->getMessage() . "<br/>");
            return false;
        }
    }

    public function crearAlumno($nombre, $fechaNac) {
        $mayorEdad = $this->checkNac($fechaNac);
        $this->Idb->query("INSERT INTO alumnos (ID, NOMBRE, FECHA_NACIMIENTO, MAYOR_EDAD) VALUES (NULL,'$nombre', '$fechaNac', '$mayorEdad')");
    }

    public function updateAlumno($id, $nombre, $fechaNac, $mayor) {
        if ($mayor) {
            $mayorEdad = 1;
        } else {
            $mayorEdad = 0;
        }
        $this->Idb->query("UPDATE alumnos SET NOMBRE='$nombre', FECHA_NACIMIENTO='$fechaNac', MAYOR_EDAD='$mayorEdad' WHERE ID='$id'");
    }

    public function borrarAlumno($id) {
        $this->Idb->query("DELETE FROM notas WHERE ID_ALUMNO = '$id'");
        $this->Idb->query("DELETE FROM alumnos WHERE ID='$id'");
    }

    private function checkNac($fecha) {
        $date = strtotime($fecha);
        //The age to be over, over +18
        $min = strtotime('+18 years', $date);
        echo $min;
        if (time() < $min) {
            return 0;
        }else{
            return 1;
        }
    }

}

?>