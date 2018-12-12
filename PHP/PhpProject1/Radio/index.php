<?php
include_once('head.html');
$server = 'localhost';
$user = 'root';
$password = '1234';
$dbname = 'radio';
// Conectar
$db = new mysqli($server, $user, $password, $dbname);
// Comprobar conexión
if($db->connect_error){
    die('La conexión ha fallado, error número ' . $db->connect_errno . ': ' . $db->connect_error);
}else{
	echo '<h1>Se ha conectado a la base de datos</h1>';
}

if($result = $db->query("SELECT * FROM programas ORDER BY codigo DESC")){
$filaActual = 0;
while($filaActual < $result->num_rows){
	$fila = $result->fetch_assoc();
	echo '<pre>';
	print_r ($fila);
	echo '</pre>';
	$filaActual++;
}
}

//Cerramos conexiones
$db->close();
?>


<?php
$server = 'localhost';
$user = 'root';
$password = '1234';
$dbname = 'radio';
// Conectar
$db = new mysqli($server, $user, $password, $dbname);
// Comprobar conexión
if($db->connect_error){
    die('La conexión ha fallado, error número ' . $db->connect_errno . ': ' . $db->connect_error);
}else{
	echo '<h1>Se ha conectado a la base de datos</h1>';
}

$consulta = mysqli_real_query($db,"SELECT * FROM invitados");
$resultado = mysqli_store_result($db);


if($consulta = mysqli_real_query($db,"SELECT * FROM invitados")){
$result = mysqli_store_result($db);

$filaActual = 0;
while($filaActual < mysqli_num_rows($result)){
	$fila = $result->fetch_assoc();
	echo '<pre>';
	print_r ($fila);
	echo '</pre>';
	$filaActual++;
}
//Cerramos conexiones
$db->close();
}
?>


<h1>SE VIENE LA MULTIQUERY</h1>
<?php
$server = 'localhost';
$user = 'root';
$password = '1234';
$dbname = 'radio';
// Conectar
$db = new mysqli($server, $user, $password, $dbname);
// Comprobar conexión
if($db->connect_error){
    die('La conexión ha fallado, error número ' . $db->connect_errno . ': ' . $db->connect_error);
}else{
	echo '<h1>Se ha conectado a la base de datos</h1>';
}

$queryEspecialidades = "SELECT distinct especialidad FROM invitados;";
$queryNombres = "SELECT distinct nombre FROM programas;";
$queryEdificios = "SELECT distinct edificio FROM locutorio;";
$insertInvitado = "INSERT INTO invitados (dni, nombre, apellidos, especialidad) VALUES('49077879P', 'Rafa', 'Aprieto', 'Informatica');";
$insertColaboracion = "INSERT INTO colaboran (cod_programa, dni_invitado, fecha) VALUES(2, '49077879P', '12-12-2018 00:00:00');";
if(mysqli_multi_query($db,$queryEspecialidades.$queryNombres.$queryEdificios.$insertInvitado.$insertColaboracion)){
    do {
        /* almacenar primer juego de resultados */
        if ($result = mysqli_store_result($db)) {
            while ($row = mysqli_fetch_row($result)) {
                printf("%s\n", $row[0]);
            }
            mysqli_free_result($result);
        }
        /* mostrar divisor */
        if (mysqli_more_results($db)) {
            printf("-----------------\n<br>");
			echo 'entra';        
		}
    } while (mysqli_next_result($db));
}
//Cerramos conexiones
$db->close();
?>
</body>
</html>