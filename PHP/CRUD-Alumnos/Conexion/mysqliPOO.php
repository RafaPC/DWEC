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
    
    public function __destruct(){
        $this->conex->close();
    }

    public function getAllAsignaturas() {
        try {
            $resultado = $this->conex->query("SELECT * FROM asignaturas");
            $filas = $resultado->fetch_all(MYSQLI_ASSOC);
            return $filas;
        } catch (mysqli_sql_exception $e) {
            echo ( "¡Error! al ejecutar consulta: " . $e->getMessage() . "<br/>");
            return false;
        }
    }

    public function getAsignatura($id) {
        try {
            $resultado = $this->conex->query("SELECT * FROM asignaturas WHERE ID ='$id'");
            $filas = $resultado->fetch_all(MYSQLI_ASSOC);
            return $filas[0];
        } catch (mysqli_sql_exception $e) {
            echo ( "¡Error! al ejecutar consulta: " . $e->getMessage() . "<br/>");
            return false;
        }
    }

    public function crearAsignatura($nombre, $curso, $ciclo) {
        $this->conex->query("INSERT INTO asignaturas (ID, NOMBRE, CURSO, CICLO) VALUES (NULL,'$nombre', '$curso', '$ciclo')");
    }

    public function updateAsignatura($id, $nombre, $curso, $ciclo) {
        $this->conex->query("UPDATE asignaturas SET NOMBRE='$nombre', CURSO='$curso', CICLO='$ciclo' WHERE ID='$id'");
    }

    public function borrarAsignatura($id) {
        $this->conex->query("DELETE FROM notas WHERE ID_ASIGNATURA = '$id'");
        $this->conex->query("DELETE FROM asignaturas WHERE ID='$id'");
    }

}
