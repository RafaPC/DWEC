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
    if (preg_match("/^\d{8}[A-Z]$/", $_POST['dni'])) {
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
            $sql = "INSERT INTO `usuarios`(`id`, `password`, `dni`, `telefono`, `fecha_nacimiento`, `email`, `saldo`) VALUES ($id, $password, $dni, $telefono, $fecha_nacimiento, $email, $saldo)";
            echo $sql;
            $resultado = $conex->query($sql);
            $conecta->cierraConexion();
            return true;
        } catch (PDOException $ex) {
            echo ( "Ãƒâ€šÃ‚Â¡Error! al ejecutar consulta: " . $ex->getMessage() . "<br/>");
            return false;
        }
    }

    public static function checkUsuario($id, $password) {
        $id = test_input($id);
        $user = self::getUsuario($id);
        if ($user === NULL) {
            return NULL;
        }
        $password = test_input($password);
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
        $comentario = test_input($_POST['comentario']);
        try {
            $resultado = $conex->query('INSERT INTO `comentarios`(`texto`, `fecha`) VALUES (' . $conex->quote($comentario) . ',CURDATE())');
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