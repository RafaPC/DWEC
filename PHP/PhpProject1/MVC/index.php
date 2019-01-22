<?php
require_once('modelo.php');
$conn = new conectaBD();
$resultadoConsulta = $conn->getPresentadores();
include_once('vista.php');
?>