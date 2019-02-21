<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('bd_mysql.php');

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    //$data = filter_var($data, FILTER_SANITIZE_STRING);

    return $data;
}

function checkDatosRegistro() {
    //$patronDNI = "/^\d{8}$/";
    $error = false;
    foreach ($_POST as $clave => $valor) {
        $_POST[$clave] = test_input($_POST[$clave]);
    }
    if (preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/", $_POST['fecha_nacimiento'])) {
        echo "fecha en buen formato";
    } else {
        echo 'fecha mal formato';
        echo $_POST['fecha_nacimiento'];
    }

    if (preg_match("/^\d{8}[A-Z]$", $_POST['dni'])) {
        echo "dni en buen formato";
    } else {
        echo 'dni mal formato';
    }
    //filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    return $error;
}

class Usuario {

    public function __construct() {
        
    }

    private function getUsuario($id) {
        $conecta = new ConectaBD();
        $conex = $conecta->obtenerConexion();
        try {
            $resultado = $conex->query("SELECT * FROM usuarios WHERE id = " . $conex->quote($id));
            $usuario = $resultado->fetchAll();
            $conecta->cierraConexion();
            if (count($usuario) === 0) {
                return NULL;
            }
            return $usuario[0];
        } catch (PDOException $ex) {
            echo ( "Ãƒâ€šÃ‚Â¡Error! al ejecutar consulta: " . $ex->getMessage() . "<br/>");
            return false;
        }
    }

    public function insertUsuario() {
        $conecta = new ConectaBD();
        $conex = $conecta->obtenerConexion();

        $id = $conn->quote($_POST['id']);
        $password = $conn->quote($_POST['password']);
        $dni = $conn->quote($_POST['dni']);
        $telefono = $conn->quote($_POST['telefono']);
        $fecha_nacimiento = $conn->quote($_POST['fecha_nacimiento']);
        $email = $conn->quote($_POST['email']);
        $saldo = $conn->quote($_POST['saldo']);

        $password = Password::hash($password);
        try {
            $resultado = $conex->query("INSERT INTO `usuarios`(`id`, `password`) VALUES (" . $conex->quote($id) . "," . $conex->quote($password) . ")");
            $conecta->cierraConexion();
            return true;
        } catch (PDOException $ex) {
            echo ( "Ãƒâ€šÃ‚Â¡Error! al ejecutar consulta: " . $ex->getMessage() . "<br/>");
            return false;
        }
    }

    public function checkUsuario($id, $password) {
        $id = test_input($id);
        $user = $this->getUsuario($id);
        if ($user === NULL) {
            return NULL;
        }
        $password = test_input($password);
        return Password::verify($password, $user['password']);
    }

}

class Comentario {

    public function __construct() {
        
    }

    public function selectTodos() {
        $conexion = new conectaBD();
        $conn = $conexion->obtenerConexion();
        try {
            $resultado = $conn->query("SELECT * FROM comentarios", PDO::FETCH_NUM);
            $filas = $resultado->fetchAll();
            $conexion->cierraConexion();
            return $filas;
        } catch (PDOException $ex) {
            echo ( "Ãƒâ€šÃ‚Â¡Error! al ejecutar consulta: " . $ex->getMessage() . "<br/>");
            return false;
        }
    }

}

class Password {

    const HASH = PASSWORD_DEFAULT;
    const COST = 10;

    public static function hash($password) {
        return password_hash($password, self::HASH, ['cost' => self::COST]);
    }

    public static function verify($password, $hash) {
        return password_verify($password, $hash);
    }

}

?>