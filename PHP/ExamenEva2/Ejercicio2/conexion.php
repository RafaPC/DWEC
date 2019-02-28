<?php

//Funciones
function validar($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

class ConectaBD {

    private $conn = null;

    public function __construct($database = 'examen') {
        $dsn = "mysql:host=localhost;dbname=$database;charset=UTF8";
        try {
            $this->conn = new PDO($dsn, 'examen', '1234');
            //Me ahorro el fetchear los resultados como asociativos cada vez que hago una select
            //poniendo el modo de fetch predeterminado como asociativo
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            die("Â¡Error!: " . $ex->getMessage() . "<br/>");
        }
    }

    public function __destruct() { // Cierra conexiÃ³n asignÃ¡ndole valor null
        $this->conn = null;
    }

    public function obtenerConexion() {
        return $this->conn;
    }

    public function cierraConexion() {
        $this->conn = null;
    }

}

class Usuario {

    public static function checkUsuario($id, $password) {
        $user = self::getUsuario($id);
        if ($user === NULL) {
            return NULL;
        }
        if (Password::verify($password, $user['contrasena'])) {
            setCookie('nombre', $user['nombre'], time() + 99999);
            return true;
        } else {
            Usuario::aumentarIntento($id);
            return false;
        }
    }

    private static function getUsuario($id) {
        global $conecta;
        $conex = $conecta->obtenerConexion();
        try {
            $resultado = $conex->query("SELECT * FROM usuarios WHERE idUsuario = " . $conex->quote($id));
            $usuario = $resultado->fetchAll();
            if (count($usuario) === 0) {
                return NULL;
            }
            return $usuario[0];
        } catch (PDOException $ex) {
            echo ( "¡Error! al ejecutar consulta: " . $ex->getMessage() . "<br/>");
            return false;
        }
    }

    private static function aumentarIntento($id) {
        global $conecta;
        $conex = $conecta->obtenerConexion();
        try {
            $conex->query('UPDATE `usuarios` SET `intentos`=`intentos`+1 WHERE `idUsuario` = ' . $conex->quote($id));
            //$conecta->cierraConexion();
        } catch (PDOException $ex) {
            echo ( "¡Error!al ejecutar consulta: " . $ex->getMessage() . "<br/>");
            return false;
        }
    }

    public static function checkValidez($id) {
        global $conecta;
        $conex = $conecta->obtenerConexion();
        try {
            $resultado = $conex->query('SELECT `fecha_validez` FROM `usuarios` WHERE `idUsuario` = ' . $conex->quote($id));
            $fecha = $resultado->fetchAll();
            //Convierto formato Y-m-d a UNIX
            $fechaValidez = strtotime($fecha[0]['fecha_validez']);
            //UNIX de fecha actual
            $fechaActual = mktime();
            if ($fechaActual < $fechaValidez) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $ex) {
            echo ( "¡Error!al ejecutar consulta: " . $ex->getMessage() . "<br/>");
            return false;
        }
    }

    public static function checkHorario($id) {
        global $conecta;
        $conex = $conecta->obtenerConexion();
        try {
            $resultado = $conex->query('SELECT `hora_ini`, `hora_fin` FROM `usuarios` WHERE `idUsuario` = ' . $conex->quote($id));
            $fecha = $resultado->fetchAll();
            //Cojo las horas del resultado de la consulta
            $horaIni = $fecha[0]['hora_ini'];
            $horaFin = $fecha[0]['hora_fin'];
            //array con hora, minutos, segundos y mas cosas de la fecha actual
            $horaActual = localtime(time(), true);
            //Paso de string separado por puntos a array con horas, minutos y segundos
            $horaIni = explode(':', $horaIni);
            $horaFin = explode(':', $horaFin);
            //Segundos totales desde que empezó el día
            $horaIni = $horaIni[0] * 3600 + $horaIni[1] * 60 + $horaIni[2];
            $horaFin = $horaFin[0] * 3600 + $horaFin[1] * 60 + $horaFin[2];
            //Lo mismo, saco los segundos totales que han pasado desde que ha empezado el día
            $horaActual = $horaActual['tm_hour'] * 3600 + $horaActual['tm_min'] * 60 + $horaActual['tm_sec'];
            if ($horaActual > $horaIni && $horaActual < $horaFin) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $ex) {
            echo ( "¡Error!al ejecutar consulta: " . $ex->getMessage() . "<br/>");
            return false;
        }
    }

    public static function checkIntentos($id) {
        global $conecta;
        $conex = $conecta->obtenerConexion();
        try {
            $resultado = $conex->query('SELECT `intentos` FROM `usuarios` WHERE `idUsuario` = ' . $conex->quote($id));
            $intentos = $resultado->fetchAll();
            //Pongo mayor también por si se ha sumado dos veces por algún problema
            if ($intentos[0]['intentos'] >= 3) {
                return false;
            } else {
                return true;
            }
        } catch (PDOException $ex) {
            echo ( "¡Error!al ejecutar consulta: " . $ex->getMessage() . "<br/>");
            return false;
        }
    }

    private static function resetearIntentos($id) {
        global $conecta;
        $conex = $conecta->obtenerConexion();
        try {
            $conex->query('UPDATE `usuarios` SET `intentos`= 0 WHERE `idUsuario` = ' . $conex->quote($id));
        } catch (PDOException $ex) {
            echo ( "¡Error!al ejecutar consulta: " . $ex->getMessage() . "<br/>");
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