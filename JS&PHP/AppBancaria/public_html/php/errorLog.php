<?php

function escribirError(PDOException $excepcion) {
    $fecha = date("j/n/Y-H:i:s");
    $mensaje = $excepcion->getMessage();
    $trace = $excepcion->getTraceAsString();
    $man = fopen('registro.log', 'a');
    $log = "
Fecha: $fecha
        
Mensaje: $mensaje 
Trace: $trace
********************************************************";
    fwrite($man, $log);
    fclose($man);
}

?>