<?php
//RADIO
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

if($result = $db->query("SELECT * FROM programas")){
    
    //Empiezo por la última fila
    $numFila = $result->num_rows;
    
//Hay x filas pero la última es x-1
    $filaResta = 1;
        while($numFila >= 0){
            
            $numFila--;
            $result->data_seek($numFila);
            $fila = $result->fetch_row();
            
            echo '<pre>';
            print_r ($fila);
            echo '</pre>';
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

if($consulta = mysqli_real_query($db,"SELECT * FROM invitados")){
$result = $db->store_result();

$filaActual = 0;
while($filaActual < $result->num_rows){
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
        if ($result = $db->store_result()) {
            while ($row = $result->fetch_row()) {
                printf("%s\n", $row[0]);
            }
            $result->free_result();
        }
        /* mostrar divisor */
        if ($db->more_results()) {
            printf("-----------------\n<br>");
			echo 'entra';        
		}
    } while ($db->next_result());
}
//Cerramos conexiones
$db->close();
?>
</body>
</html>