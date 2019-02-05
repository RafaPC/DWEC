<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
require_once '../Conexion/conexion.php';
$conex = Singleton::getConex();
$url = htmlspecialchars($_SERVER["PHP_SELF"]);
$campoElegido = false;
$alumno = ['ID', 'Nombre', 'Fecha de nacimiento', 'Mayor de edad'];
if (isset($_GET['id']) || isset($_SESSION['id'])) {
    if (isset($_GET['id'])) {
        $_SESSION['id'] = $_GET['id'];
    }
    $campoElegido = true;
    //Hacer funcion de rellenar campos que sirva para notas y alumnos, 
    //puede que me haya flipado y no sea tan viable
    $alumno = $conex->getAlumnoOrClase("alumnos", $_SESSION['id']);
}
if (isset($_POST['submit'])) {
    $funcion = $_POST['submit'];
    if ($funcion === 'Crear') {
        $conex->crearAlumno($_POST['NOMBRE'],$_POST['FECHA_NACIMIENTO'],$_POST['MAYOR_EDAD']);
    } else if ($funcion === 'Actualizar') {
        
    } else if ($funcion === 'Borrar') {
        
    }
}

$consulta = $conex->getAllFromX('alumnos');
$titulo = 'Crud alumnos';
require_once '../head.php';
require_once '../tabla.php';
?>
<form method="post" action="<?php echo $url ?>">
    <div id="filaBotones">
        <?php
        echo "<input type=\"submit\" value=\"Crear\">";
        echo "<input type=\"submit\" value=\"Actualizar\">";
        echo "<input type=\"submit\" value=\"Borrar\">";
        ?>
    </div>
    <?php
    foreach ($alumno as $clave => $valor) {
        echo "<input type=\"text\" name=\"$clave\" value=\"$valor\">";
    }
    ?>

</form>
</body>
</html>