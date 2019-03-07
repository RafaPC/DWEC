<?php

require_once 'errorLog.php';
$objetoRespuesta = new stdClass();

if (isset($_POST['cod_cuenta'])) {
    try {
        $codCuenta = $_POST['cod_cuenta'];
        if (strlen($codCuenta) === 10) {
            $ultimoNumero = substr($codCuenta, 9, 1);
            for ($i = 0, $acum = 0; $i < strlen($codCuenta) - 1; $i++) {
                $acum += $codCuenta[$i];
            }
            if ($acum % 9 == $ultimoNumero) {
                require_once 'conexion.php';
                $conex = Conexion::getConex();
                //Consulta
                $selectCuenta = "SELECT cod_cuenta FROM cuentas WHERE cod_cuenta = '$codCuenta'";
                $result = $conex->query($selectCuenta);
                $numRows = $result->fetchColumn();
                if ($numRows) {
                    $objetoRespuesta->cod_err = 1;
                } else {
                    die('{"cod_err":-3}');
                }
            } else {
                die('{"cod_err":-2}');
            }
        } else {
            die('{"cod_err":-1}');
        }
    } catch (Exception $ex) {
        escribirError($ex);
        die('{"cod_err":-8}');
    }
} else {
    die('{"cod_err":-8}');
}

$objetoJSON = json_encode($objetoRespuesta);
echo $objetoJSON;

//Cerrar conex
$conex = null;
?>