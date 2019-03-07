<?php

$conn =new mysqli('localhost', 'root', '1234');
if (!$conn) {
    die('No pudo conectarse: ');
}

$sql = 'DROP DATABASE banco';
if ($conn->query($sql)) {
    echo "La base de datos banco fue eliminada con éxito\n";
} else {
    echo 'Error al eliminar la base de datos: ';
}