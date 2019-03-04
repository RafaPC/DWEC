<?php
function convertirFecha($fecha) {
    $nuevaFecha = (new DateTime(str_replace('/', '-', $fecha)))->format('Y-m-d');
    return $nuevaFecha;
}
?>