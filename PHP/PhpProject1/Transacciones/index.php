<?php
include_once('head.html');
$server = 'localhost';
$user = 'root';
$password = '1234';
$dbname = 'radio';
// Conectar
$db = new mysqli($server, $user, $password, $dbname);
// Comprobar conexión
if ($db->connect_error) {
    die('La conexión ha fallado, error número ' . $db->connect_errno . ': ' . $db->connect_error);
} else {
    echo '<h1>Se ha conectado a la base de datos</h1>';
}
// Preparar
$db->autocommit(false);

if ($db->query("INSERT INTO invitados (dni, nombre, apellidos, especialidad) VALUES ('12345678P', 'Frank', 'Grimes', 'Algo');")) {
    echo '<h1>Invitado insertado</h1>';
    if ($db->query("INSERT INTO programas (codigo, nombre, duracion, hora_inicio, cod_locutorio, dni_presentador) VALUES (5, 'Nadie sabe nada', 50, '13:00:00', 106, '11111111A');")) {
        echo '<h1>Programa insertado</h1>';
        if ($db->query("INSERT INTO colaboran (cod_programa, dni_invitado, fecha) VALUES (5, '12345678P', '12-12-2018 00:00:00');")) {
            echo '<h1>Colaboración insertada</h1>';
            $db->commit();

            if ($db->query("INSERT INTO colaboran (cod_programa, dni_invitado, fecha) VALUES (2, '12345678P', '12-12-2018 00:00:00');")) {
                echo '<h1>Colaboración insertada</h1>';
                $db->rollback();
            } else {
                echo 'Error: ' . $db->error;
            }
        } else {
            echo 'Error: ' . $db->error;
        }
    } else {
        echo 'Error: ' . $db->error;
    }
} else {
    echo 'Error: ' . $db->error;
}

if ($result = $db->query("SELECT i.dni, i.nombre, i.apellidos, p.nombre FROM invitados i JOIN colaboran c ON (i.dni = c.dni_invitado) JOIN programas p ON(p.codigo = c.cod_programa);")) {
    $filaActual = 0;
    while ($filaActual < $result->num_rows) {
        $fila = mysqli_fetch_array($result);
        echo '<pre>';
        print_r($fila);
        echo '</pre>';
        $filaActual++;
    }
} else {
    echo 'Error: ' . $db->error;
}

//Cerramos conexiones
$db->close();
?>
</body>
</html>