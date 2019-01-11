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
            echo '<table><tr>';
            $claves = array();
            foreach ($consulta as $clave => $valor) {
                echo "<th>$clave</th>";
                array_push($claves, $clave);
            }
            echo '</tr>';
            foreach ($consulta as $clave => $fila) {
                echo '<tr>';
                //echo "<tr><td>" . $fila['dni'] . "</td><td>" . $fila['nombre'] . "</td><td>" . $fila['apellidos'] . "</td><td>" . $fila['sueldo'] . "</td></tr>";
                for ($i = 0; $i < count($claves); $i++) {
                    
                    $x = $claves[$i];
                    echo $claves[$i];
                    echo "<td>$fila[$x]</td>";
                }
                echo '</tr>';
            }
            echo "</table>";
        }
    }

}

// ----------- Proceso principal
$obj = new conectaBD('radio'); // crea conexión para usar bd empresa
$sql = 'SELECT * FROM presentadores';
$resultado = $obj->consulta2($sql); // invoca método de objeto para ejecutar consulta
$obj->muestra($resultado);
//if ($resultado) {
//    foreach ($resultado as $k => $fila) {
//        if ($k == 0) {
//            echo "<table><tr><th>Codigo</th><th>Apellido</th><th>Oficio</th></tr>";
//        }
//        echo "<tr><td>" . $fila['emp_no'] . "</td><td>" . $fila['apellido'] . "</td><td>" . $fila['oficio'] . "</td></tr>";
//    }
//    echo "</table>";
//}
?>