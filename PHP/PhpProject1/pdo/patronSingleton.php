<?php

class patronSingleton {

    private $Idb;
    private $filas = array();
    private static $instancia; // contenedor de la instancia

    private function __construct() { //método singleton que crea instancia sí no está creada
        $this->Idb = new PDO('mysql:host=localhost;dbname=radio;charset=UTF8', 'root', '1234');
    }

    public static function singleton() { //método singleton que crea instancia sí no está creada
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }

    public function __clone() { // Evita que el objeto se pueda clonar
        trigger_error('La clonación de este objeto no está permitida', E_USER_ERROR);
    }

    public function getPresentadores() { //método con el que obtenemos datos de la tabla presentadores
        $consulta = $this->Idb->prepare("SELECT * FROM presentadores");
        $consulta->execute();
        if ($consulta->rowCount() > 0) {
            while ($row = $consulta->fetch()) {
                $this->filas[] = $row;
            }

            return $this->filas;
        }
    }
    
    public function getInvitados() { //método con el que obtenemos datos de la tabla invitados
        $consulta = $this->Idb->prepare("SELECT * FROM invitados");
        $consulta->execute();
        if ($consulta->rowCount() > 0) {
            while ($row = $consulta->fetch()) {
                $this->filas[] = $row;
            }

            return $this->filas;
        }
    }
    
    public function muestra($consulta) {
        if ($consulta) {
            ?><table><thead><tr><?php
            foreach ($consulta[0] as $clave => $valor) {
                echo "<th style=\"border: 1px solid black\">" . $clave . "</th>";
            }
            ?></tr></thead><?php
            foreach ($consulta as $indice => $fila) {
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

$conDB = patronSingleton::singleton();
$presentadores = $conDB->getPresentadores();
$conDB::muestra($presentadores);
$invitados = $conDB->getInvitados();
$conDB::muestra($invitados);
?>