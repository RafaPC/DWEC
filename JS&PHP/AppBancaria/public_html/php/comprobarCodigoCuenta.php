<?php

$objetoRespuesta = new stdClass();

if (isset($_POST['cod_cuenta'])) {
    $codCuenta = $_POST['cod_cuenta'];
    
    //AQUI PONER UN REGEXP, MELÓN
    if (strlen($codCuenta) === 10) {
        $ultimoNumero = substr($codCuenta, 9, 1);
        for ($i = 0, $acum = 0; $i < strlen($codCuenta) - 1; $i++) {
            $acum += $codCuenta[$i];
        }
        if ($acum % 9 == $ultimoNumero) {
            require_once 'configuracion/constantes_bbdd.php';

            try {
                $conex = new PDO(DSN, USER, PASSWORD);
            } catch (PDOException $ex) {
                $objetoRespuesta->cod_err = -4;
                die("Error!: " . $ex->getMessage() . "<br>");
            }
            //consulta
            $selectCuenta = "SELECT cod_cuenta FROM cuentas WHERE cod_cuenta = '$codCuenta'";
            $result = $conex->query($selectCuenta);
            $numRows = $result->fetchColumn();
            if ($numRows) {
                $objetoRespuesta->existe = true;
                $objetoRespuesta->cod_err = 1;
            } else {
                $objetoRespuesta->existe = false;
                $objetoRespuesta->cod_err = -3;
            }
        } else {
            $objetoRespuesta->cod_err = -2;
        }
    } else {
        $objetoRespuesta->cod_err = -1;
    }
} else {
    $objetoRespuesta->cod_err = -4;
}

$objetoJSON = json_encode($objetoRespuesta);
echo $objetoJSON;
//cerrar conex
$conex = null;
?>