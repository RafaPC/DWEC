<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class conectaBD {

    private $conn = null;

    public function __construct($database = 'test') {
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

    public function insertaPresentador($dni, $nombre, $apellidos, $sueldo) {
        // Prepara y ejecuta consulta
        $datos = array(':par1' => $dni, ':par2' => $nombre, ':par3' => $apellidos, ':par4' => $sueldo);
        $sql = ' INSERT INTO presentadores (dni,nombre,apellidos,sueldo)
VALUES ( :par1 , :par2 , :par3, :par4) ';
        $q = $this->conn->prepare($sql);
        return $q->execute($datos);
    }

    public function updatePresentador($dni, $nombre, $apellidos, $sueldo) { // Prepara y ejecuta consulta
        $datos = array(':par1' => $dni, ':par2' => $nombre, ':par3' => $apellidos, ':par4' => $sueldo);
        $sql = ' UPDATE presentadores SET nombre= :par2, apellidos= :par3, sueldo= :par4 WHERE dni=:par1 ';
        $q = $this->conn->prepare($sql);
        return $q->execute($datos);
    }

    public function borraPresentador($dni) { // Prepara y ejecuta consulta
        $datos = array(':par1' => $dni);
        //$sqlProg = ' DELETE FROM programas WHERE dni_presentador= :par1 ';
        //$q = $this->conn->prepare($sqlProg);
        //$q->execute($datos);
        $sql = ' DELETE FROM presentadores WHERE dni= :par1 ';
        $q = $this->conn->prepare($sql);
        $q->execute($datos);
        return $q->execute($datos);
    }

    public function consulta2($orden) { // Ejecuta consulta y devuelve array de resultados o NULL sí falla ejecución
        $filas = array();
        $q = $this->conn->query($orden);
        if ($q !== false) {
            $q->setFetchMode(PDO::FETCH_ASSOC);

            while ($r = $q->fetch()) {
                $filas[] = $r;
            }
        }
        return $filas;
    }

    public function muestra($consulta) {
        if ($consulta) {
            echo '<table><thead><tr>';
            foreach ($consulta[0] as $clave => $valor) {
                echo "<th style=\"border: 1px solid black\">" . $clave . "</th>";
            }
            echo '</tr></thead>';
            foreach ($consulta as $indice => $fila) {
                echo '<tbody><tr>';
                foreach ($fila as $clave => $valor) {
                    echo "<td style=\"border: 1px solid black\">$valor</td>";
                }
                echo '</tr>';
            }
            echo "</tbody></table>";
        }
    }

}

include_once 'head.html';

$obj = new conectaBD('radio'); // crea conexión para usar bd empresa
if ($obj->insertaPresentador('43398576P', 'Luis', 'Dominguez', 2500) !== false) {
    echo 'se inserto con exito';
    $obj->updatePresentador('43398576P', 'Luis', 'NoDominguez', 2500);
    $obj->borraPresentador('11111111A');
    $resultado = $obj->consulta2('SELECT * FROM presentadores');
    $obj->muestra($resultado);
} else {
    echo 'fallo al insertar';
}
?>
</body>
</html>