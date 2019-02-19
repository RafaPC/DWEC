<?php
require_once('modelo/modelo.php');
$presentadores = new Presentadores();
$resultadoConsulta = $presentadores->getPresentadores();
require_once('vista.php');
?>