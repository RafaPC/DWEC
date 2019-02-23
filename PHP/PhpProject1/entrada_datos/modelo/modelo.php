<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('bd_mysql.php');

function validar($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    //$data = filter_var($data, FILTER_SANITIZE_STRING);
    return $data;
}

function checkDatosRegistro() {
    foreach ($_POST as $clave => $valor) {
        $_POST[$clave] = validar($_POST[$clave]);
    }
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $error = 'Formato de email incorrecto.';
    }
    if (!preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/", $_POST['fecha_nacimiento'])) {
        $error = 'Formato de fecha incorrecto';
    }
    if (!preg_match("/^91\d{7}$/", $_POST['telefono'])) {
        $error = 'Formato de telefono incorrecto.';
    }
    if (!preg_match("/^\d{8}[A-Z]$/", $_POST['dni'])) {
        $error = 'Formato de DNI incorrecto.';
    }

    if (isset($error)) {
        return $error;
    } else {
        return true;
    }
}

class Usuario {

    public function __construct() {
        
    }

    private static function getUsuario($id) {
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

    public static function insertUsuario() {
        $conecta = new ConectaBD();
        $conex = $conecta->obtenerConexion();
        $id = $conex->quote($_POST['id']);
        $dni = $conex->quote($_POST['dni']);
        $telefono = $conex->quote($_POST['telefono']);
        $fecha_nacimiento = $conex->quote($_POST['fecha_nacimiento']);
        $email = $conex->quote($_POST['email']);
        $saldo = $conex->quote($_POST['saldo']);
        $password = Password::hash($_POST['password']);
        $password = $conex->quote($password);
        try {
            $resultado = $conex->query("INSERT INTO `usuarios`(`id`, `password`, `dni`, `telefono`, `fecha_nacimiento`, `email`, `saldo`) VALUES ($id, $password, $dni, $telefono, $fecha_nacimiento, $email, $saldo)");
            $conecta->cierraConexion();
            return true;
        } catch (PDOException $ex) {
            echo ( "Ãƒâ€šÃ‚Â¡Error! al ejecutar consulta: " . $ex->getMessage() . "<br/>");
            return false;
        }
    }

    public static function checkUsuario($id, $password) {
        $id = validar($id);
        $user = self::getUsuario($id);
        if ($user === NULL) {
            return NULL;
        }
        $password = validar($password);
        return Password::verify($password, $user['password']);
    }

}

class Comentarios {

    public function __construct() {
        
    }

    public static function selectTodos() {
        $conexion = new conectaBD();
        $conex = $conexion->obtenerConexion();
        try {
            $resultado = $conex->query("SELECT * FROM comentarios", PDO::FETCH_NUM);
            $filas = $resultado->fetchAll();
            $conexion->cierraConexion();
            return $filas;
        } catch (PDOException $ex) {
            echo ( "Ãƒâ€šÃ‚Â¡Error! al ejecutar consulta: " . $ex->getMessage() . "<br/>");
            return false;
        }
    }

    public static function insertComentario() {
        $conexion = new conectaBD();
        $conex = $conexion->obtenerConexion();
        $comentario = validar($_POST['comentario']);
        try {
            $resultado = $conex->query('INSERT INTO `comentarios`(`texto`, `fecha`) VALUES (' . $conex->quote($comentario) . ',NOW())');
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
    const COST = 14;

    public static function hash($password) {
        return password_hash($password, self::HASH, ['cost' => self::COST]);
    }

    public static function verify($password, $hash) {
        return password_verify($password, $hash);
    }

}

?>