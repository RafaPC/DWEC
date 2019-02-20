<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function filtrar($string) {
    
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    //$data = filter_var($data, FILTER_SANITIZE_STRING);

    return $data;
}

class Usuario {

    public function __construct() {
        
    }

    private function getUsuario($id) {
        require_once('bd_mysql.php');
        
        try {
            $resultado = $conn->query("SELECT * FROM usuarios WHERE id = $conn->quote($id)");
            $usuario = $resultado->fetchAll();
            $conexion->cierraConexion();
            return $usuario;
        } catch (PDOException $ex) {
            echo ( "Â¡Error! al ejecutar consulta: " . $ex->getMessage() . "<br/>");
            return false;
        }
    }

    public function checkUsuario($id, $password) {
        $id = test_input($id);
        $usuario = $this->getUsuario($id);
        if($usuario === NULL){
            return NULL;
        }
        $password = test_input($password);
        return Password::verify($password, $usuario[1]);
    }

}

class Comentario {

    public function __construct() {
        
    }

    public function selectTodos() {
        require_once('bd_mysql.php');
        $conexion = new conectaBD();
        $conn = $conexion->obtenerConexion();
        try {
            $resultado = $conn->query("SELECT * FROM comentarios");
            $filas = $resultado->fetchAll();
            $conexion->cierraConexion();
            return $filas;
        } catch (PDOException $ex) {
            echo ( "Â¡Error! al ejecutar consulta: " . $ex->getMessage() . "<br/>");
            return false;
        }
    }

}

class Password {

    const HASH = PASSWORD_DEFAULT;
    const COST = 14;

    public static function hash($password) {
        return password_hash($password, self::HASH, ['cost' => self::COST]);
    }

    public static function verify($password, $hash) {
        return password_verify($password, $hash);
    }

}

?>