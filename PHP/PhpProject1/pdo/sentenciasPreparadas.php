<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class conectaBD {

    private $conn = null;

    public function __construct($database = 'test') {
        $dsn = "mysql:host=localhost;dbname=$database";
        try {
            $this->conn = new PDO($dsn, 'root', '1234');
        } catch (PDOException $e) {
            die("¡Error!: " . $e->getMessage() . "<br/>");
        }
    }

    public function __destruct() { // Cierra conexión asignándole valor null
        $this->conn = null;
    }

    public function insertaPresentador($dni, $nombre, $apellidos, $sueldo) {
        // Prepara y ejecuta consulta
        $datos = array(':par1' => $dni, ':par2' => $nombre, ':par3' => $apellidos, ':par4' => $sueldo);
        $sql = ' INSERT INTO presentadores (dni,nombre,apellidos,sueldo)
VALUES ( :par1 , :par2 , :par3, :par4 , :par5) ';
        $q = $this->conn->prepare($sql);
        return $q->execute($datos);
    }

    public function updatePresentador($dni, $nombre, $apellidos, $sueldo) { // Prepara y ejecuta consulta
        $datos = array(':par1' => $dni, ':par2' => $nombre, ':par3' => $apellidos, ':par4' => $sueldo);
        $sql = ' UPDATE empleados SET nombre= :par2, apellidos= :par3, sueldo= :par4 WHERE dni=:par1 ';
        $q = $this->conn->prepare($sql);
        return $q->execute($datos);
    }

    public function borraPresentador($dni) { // Prepara y ejecuta consulta
        $datos = array(':par1' => $dni);
        $sql = ' DELETE FROM presentadores WHERE dni=:par1 ';
        $q = $this->conn->prepare($sql);
        return $q->execute($datos);
    }

}

// ----------- Proceso principal
$obj = new conectaBD('radio'); // crea conexión para usar bd empresa
if ($obj->insertaPresentador('43398576P', 'Luis', 'Dominguez', 2500) !== false) {
    echo 'se inserto con exito';
    $obj->updatePresentador('43398576P','Luis','Dominguez',2500);
} else {
    echo 'fallo al insertar';
}
?>