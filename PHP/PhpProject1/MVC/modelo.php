<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class conectaBD {

    private $conn = null;

    public function __construct($database = 'radio') {
        $dsn = "mysql:host=localhost;dbname=$database;charset=UTF8";
        try {
            $this->conn = new PDO($dsn, 'root', '1234');
        } catch (PDOException $e) {
            die("¡Error!: " . $e->getMessage() . "<br/>");
        }
    }

    public function __destruct() { // Cierra conexión asignándole valor null
        $this->conn = null;
    }

    public function consulta1($orden) { // Ejecuta consulta y devuelve array de resultados o FALSE sí falla ejecución
        try {
            $q = $this->conn->query($orden);
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

    /*public function consulta2($orden) { // Ejecuta consulta y devuelve array de resultados o NULL sí falla ejecución
        $filas = array();
        $q = $this->conn->query($orden);
        if ($q !== false) {
            $q->setFetchMode(PDO::FETCH_ASSOC);

            while ($r = $q->fetch()) {
                $filas[] = $r;
            }
        }
        return $filas;
    }*/

	public function getPresentadores(){
		try {
            $q = $this->conn->query("SELECT * FROM presentadores");
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
}
?>