<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class conectaBD {

    private $conn = null;

    public function __construct($database = 'entrada') {
        $dsn = "mysql:host=localhost;dbname=$database;charset=UTF8";
        try {
            $this->conn = new PDO($dsn, 'root', '1234');
        } catch (PDOException $ex) {
            die("Â¡Error!: " . $ex->getMessage() . "<br/>");
        }
    }

    public function __destruct() { // Cierra conexiÃ³n asignÃ¡ndole valor null
        $this->conn = null;
    }
    
    public function obtenerConexion(){
        return $this->conn;
    }
    
    public function cierraConexion(){
        $this->conn = null;
    }

}

?>