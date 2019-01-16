<?php
class Conecta {

    private $conn = null;

    public function __construct($database = 'radio') {
        $dsn = "mysql:host=localhost;dbname=$database;charset=UTF8";
        try {
            $this->conn = new PDO($dsn, 'root', '1234');
        } catch (PDOException $e) {
            die("¡Error!: " . $e->getMessage() . "<br/>");
        }
    }

	public function obtenerConexion(){
		return $this->conn;
	}
	
    public function cerrarConexion() { // Cierra conexión asignándole valor null
        $this->conn = null;
    }
}
?>