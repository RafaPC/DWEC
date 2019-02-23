<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ConexionBD {

    private $conex;

    public function __construct() {
        $this->conex = new mysqli("localhost", "root", "1234", "crud");
        if ($this->conex->connect_error) {
            die('La conexión ha fallado, error número ' . $this->conex->connect_errno . ': ' . $this->conex->connect_error);
        }
    }

    public function __destruct() {
        $this->conex->close();
    }

    public function getAllAlumnos() {
        try {
            $resultado = mysqli_query($this->conex, "SELECT * FROM alumnos");
            $filas = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
            return $filas;
        } catch (mysqli_sql_exception $e) {
            echo ( "¡Error! al ejecutar consulta: " . $e->getMessage() . "<br/>");
            return false;
        }
    }

    public function getAllAsignaturas() {
        try {
            $resultado = mysqli_query($this->conex, "SELECT * FROM asignaturas");
            $filas = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
            return $filas;
        } catch (mysqli_sql_exception $e) {
            echo ( "¡Error! al ejecutar consulta: " . $e->getMessage() . "<br/>");
            return false;
        }
    }

    public function getNota($alumno, $asignatura) {
        try {
            $resultado = mysqli_query($this->conex, "SELECT NOTA FROM notas WHERE ID_ALUMNO='$alumno' AND ID_ASIGNATURA='$asignatura'");
            $nota = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
            if (count($nota) === 0) {
                return null;
            } else {
                return $nota[0]['NOTA'];
            }
        } catch (mysqli_sql_exception $e) {
            echo ( "¡Error! al ejecutar consulta: " . $e->getMessage() . "<br/>");
            return false;
        }
    }

    public function cambiarNota($alumno, $asignatura, $nota) {
        try {
            $resultado = mysqli_real_query($this->conex, "UPDATE notas SET NOTA='$nota' WHERE ID_ALUMNO='$alumno' AND ID_ASIGNATURA='$asignatura'");
            return $resultado;
            
        } catch (mysqli_sql_exception $e) {
            echo ( "¡Error! al ejecutar consulta: " . $e->getMessage() . "<br/>");
        }
    }

}
