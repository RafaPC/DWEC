<?php
require_once('modelo/modelo.php');
$presentadores = new Presentadores();
$resultadoConsulta = $presentadores->getPresentadores();
include_once('vista.php');
?>