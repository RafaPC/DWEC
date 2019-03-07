<?php

class Conexion {

    private static $pdo;
    private static $config;

    private function __construct() { //método singleton que crea instancia sí no está creada
        self::$config = parse_ini_file('configuracion/constantes_bbdd.ini');
        try {
            self::$pdo = new PDO(self::$config['conector'] . ':host=' . self::$config['host'] . ';dbname=' . self::$config['nombre_bbdd'] . ';charset=' . self::$config['charset'], self::$config['user'], self::$config['password']);
        } catch (Exception $ex) {
            //Si falla al crear la conexión se escribe el error en el registro
            escribirError($ex);
            //Pone error de acceso a la base de datos
            die('{"cod_err":-9}');
        }
    }

    public static function getConex() { //método singleton que crea instancia sí no está creada
        $miclase = __CLASS__;
        new $miclase;
        return self::$pdo;
    }

}

?>