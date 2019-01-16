<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Presentador {

    private $consultaPresentadores;

    public function getPresentadores() {
        try {
            $q = $conn->query("SELECT * FROM presentadores");
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