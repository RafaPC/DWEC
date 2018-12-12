<?php
include_once('head.html');
$server = 'localhost';
$user = 'root';
$password = '1234';
$dbname = 'dwes';
// Conectar
$db = new mysqli($server, $user, $password, $dbname);
// Comprobar conexión
if($db->connect_error){
    die('La conexión ha fallado, error número ' . $db->connect_errno . ': ' . $db->connect_error);
}else{
	echo '<h1>Se ha conectado a la base de datos</h1>';
}
// Preparar
$stmtInsert = $db->prepare('INSERT INTO usuarios (login, clave) VALUES (?, ?)');
$stmtInsert->bind_param('ss', $login, $clave);
// Establecer parámetros y ejecutar
$login = 'Donald Trump';
$clave = 'fakenews';
$stmtInsert->execute();
$login = 'monabonda';
$clave = 'manobuena';
$stmtInsert->execute();
// Mensaje de éxito en la inserción
echo "Se han creado las entradas exitosamente<br>";

//Preparar
$stmtDelete = $db->prepare('DELETE FROM usuarios WHERE login = ?');
$stmtDelete->bind_param('s', $login);
// Establecer parámetros y ejecutar
$login = 'monabonda';
$stmtDelete->execute();
// Mensaje de éxito en la inserción
echo 'Se han borrado las entradas exitosamente';

//Preparar
echo 'pasa';
$stmt = $db->prepare('SELECT * FROM usuarios');
$stmt->execute();
echo 'entra';
    // Vinculamos variables a columnas
    $stmt->bind_result($login, $clave);
    // Obtenemos los valores
    echo '<br><table style="border: 1px solid black"><tr><td>login</td><td>clave</td></tr>';
	while ($stmt->fetch()) {
		echo "<tr><td>$login</td><td>$clave</td></tr>";
    }
	echo '</table>';
    // Cerramos la sentencia preparada
    $stmt->close();
	
//Cerramos conexiones
$db->close();
?>
</body>
</html>