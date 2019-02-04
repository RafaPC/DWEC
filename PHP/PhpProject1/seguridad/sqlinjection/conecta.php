<?php
class conectaBD {

    private $conn = null;

    public function __construct($database = 'prueba') {
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

    public function consulta($nombre, $contra) { // Ejecuta consulta y devuelve array de resultados o NULL sí falla ejecución
        $orden = "Select * from usuarios where nombre='$nombre' and contrasenia='$contra'";
		
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
	
	public function consulta2($nombre, $contra) { // Ejecuta consulta y devuelve array de resultados o NULL sí falla ejecución
        $orden = "Select * from usuarios where nombre=". $this->conn->quote($nombre) . " and contrasenia=" . $this->conn->quote($contra) . ";";
		
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

}
?>