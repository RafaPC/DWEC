<?php
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
	
	public function consultaRow($orden) { // Ejecuta consulta y devuelve array de resultados o FALSE sí falla ejecución
        try {
            $resultado = $this->conn->query($orden);
            $filas = $resultado->rowCount();
            return $filas;
        } catch (PDOException $e) {
            echo ( "¡Error! al ejecutar consulta: " . $e->getMessage() . "<br/>");
            return false;
        }
    }

    public function muestra($consulta) {
        if ($consulta) {
            echo '<table><tr>';
            $claves = array();
			foreach($consulta[0] as $clave => $valor){
                array_push($claves, $clave);
					echo "<td style=\"border: 1px solid black\">$clave</td>";
            }
            echo '</tr>';
            foreach ($consulta as $clave => $fila) {
                echo '<tr>';
                //echo "<tr><td>" . $fila['dni'] . "</td><td>" . $fila['nombre'] . "</td><td>" . $fila['apellidos'] . "</td><td>" . $fila['sueldo'] . "</td></tr>";
                for ($i = 0; $i < count($claves); $i++) {
                    $x = $claves[$i];
					//echo $claves[$i];
                    echo "<td style=\"border: 1px solid black\">$fila[$x]</td>";
                }
                echo '</tr>';
            }
            echo "</table>";
        }
    }
	
	public function close(){
		$this->conn = null;
	}

}
?>