<?php
//Esto dará mal
$titulo = 'Titulo php';
require_once 'modelo.php';
$conexion = new conectaBD();
$resultadoConsulta = $conexion->getPresentadores();
$contenido = require_once('miplantilla.php');
require_once('milayout_1.php');
?>