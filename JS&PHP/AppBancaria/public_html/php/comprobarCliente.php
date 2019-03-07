<?php

require_once 'errorLog.php';
$objetoRespuesta = new stdClass();

if (isset($_POST['dni'])) {
    $dni = $_POST['dni'];
    try {
        if (strlen($dni) === 9) {
            $patronDNI = "/^\d{8}[A-Z]{1}$/";
            if (preg_match($patronDNI, $dni)) {
                require_once 'conexion.php';
                $conex = Conexion::getConex();
                $conex->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_NUM);
                $selectCliente = "SELECT * FROM `clientes` WHERE dni = '$dni'";
                //Consulta
                $result = $conex->query($selectCliente);
                $cliente = new stdClass();
                foreach ($result as $row) {
                    foreach ($row as $clave => $valor) {
                        $cliente->$clave = $valor;
                    }
                }
                $objetoRespuesta->cliente = $cliente;
            } else {
                die('{"cod_err":-2}');
            }
        } else {
            die('{"cod_err":-1}');
        }
    } catch (Exception $ex) {
        escribirError($ex);
        die('{"cod_err":-5}');
    }
} else {
    die('{"cod_err":-5}');
}
$objetoJSON = json_encode($objetoRespuesta);
echo $objetoJSON;
//cerrar conex
$conex = null;
?>