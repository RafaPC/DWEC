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

function checkDatosInput() {
    $patronDNI = "/^\d{8}$/";
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
            return $usuario[0];
        } catch (PDOException $ex) {
            echo ( "Ã‚Â¡Error! al ejecutar consulta: " . $ex->getMessage() . "<br/>");
            return false;
        }
    }

    public function insertUsuario($id, $password) {
        $id = test_input($id);
        $password = test_input($password);
        $conecta = new ConectaBD();
        $conex = $conecta->obtenerConexion();
        $password = Password::hash($password);
        try {
            $resultado = $conex->query("INSERT INTO `usuarios`(`id`, `password`) VALUES (" . $conex->quote($id) . "," . $conex->quote($password) . ")");
            $conecta->cierraConexion();
            return true;
        } catch (PDOException $ex) {
            echo ( "Ã‚Â¡Error! al ejecutar consulta: " . $ex->getMessage() . "<br/>");
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
            echo ( "Ã‚Â¡Error! al ejecutar consulta: " . $ex->getMessage() . "<br/>");
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