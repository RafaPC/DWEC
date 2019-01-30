<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 GRANT SELECT ON `radio`.`presentadores` TO 'prueba'@'localhost' IDENTIFIED BY PASSWORD '*A4B6157319038724E3560894F7F932C8886EBFCF';
 */

class conectaBD {

    private $conn = null;

    public function __construct($database = 'radio') {
        $dsn = "mysql:host=localhost;dbname=$database;charset=UTF8";
        try {
            $this->conn = new PDO($dsn, 'prueba', '1234');
        } catch (PDOException $e) {
            die("¡Error!: " . $e->getMessage() . "<br/>");
        }
    }

    public function __destruct() { // Cierra conexión asignándole valor null
        $this->conn = null;
    }

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
	
	public function getProgramas(){
		try {
            $q = $this->conn->query("SELECT * FROM programas");
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
	public function mostrar($resultadoConsulta){
	if ($resultadoConsulta) {
            ?><table><thead><tr><?php
            foreach ($resultadoConsulta[0] as $clave => $valor) {
                echo "<th style=\"border: 1px solid black\">" . $clave . "</th>";
            }
            ?></tr></thead><?php
            foreach ($resultadoConsulta as $indice => $fila) {
                ?><tbody><tr><?php
                foreach ($fila as $clave => $valor) {
                    echo "<td style=\"border: 1px solid black\">$valor</td>";
                }
                ?></tr><?php
            }
            ?></tbody></table><?php
        }
	}
}
require_once('head.html');
$conex = new conectaBD();
$resultado = $conex->getPresentadores();
$conex->mostrar($resultado);

$resultado = $conex->getProgramas();
$conex->mostrar($resultado);
?>
</body>
</html>