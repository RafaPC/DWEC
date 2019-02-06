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
$alumno = ['ID', 'Nombre', 'Fecha de nacimiento'];
if (isset($_GET['ID']) || isset($_SESSION['ID'])) {
    if (isset($_GET['ID'])) {
        $_SESSION['ID'] = $_GET['ID'];
    }
    $campoElegido = true;
    //Hacer funcion de rellenar campos que sirva para notas y alumnos, 
    //puede que me haya flipado y no sea tan viable
}
if (isset($_GET['submit'])) {
    $funcion = $_GET['submit'];
    if ($funcion === 'Crear') {
        $conex->crearAlumno($_GET['NOMBRE'], $_GET['FECHA_NACIMIENTO'], $_GET['MAYOR_EDAD']);
    } else if ($funcion === 'Actualizar') {
        if (isset($_SESSION['ID'])) {
            $conex->updateAlumno($_GET['ID'], $_GET['NOMBRE'], $_GET['FECHA_NACIMIENTO'], $_GET['MAYOR_EDAD']);
        } else {
            
        }
    } else if ($funcion === 'Borrar') {
        if (isset($_SESSION['ID'])) {
            $conex->borrarAlumno($_GET['ID']);
            unset($_SESSION['ID']);
        } else {
            
        }
    }
}
if(isset($_SESSION['ID'])) {
    $alumno = $conex->getAlumnoOrClase("alumnos", $_SESSION['ID']);
}
$consulta = $conex->getAllFromX('alumnos');
$titulo = 'Crud alumnos';
require_once '../head.php';
require_once '../tabla.php';
?>
<form method="get" action="<?php echo $url ?>">
    <div id="filaBotones">
        <?php
        echo "<input type=\"submit\" name=\"submit\" value=\"Crear\">";
        echo "<input type=\"submit\" name=\"submit\" value=\"Actualizar\">";
        echo "<input type=\"submit\" name=\"submit\" value=\"Borrar\">";
        ?>
    </div>
    <?php
    //No se si al crear se elige el mayor de edad o se mira la fecha y se selecciona solo
    foreach ($alumno as $clave => $valor) {
        echo "<input type=\"text\" name=\"$clave\" value=\"$valor\">";
    }
    //echo "<input type=\"\"";
    ?>

</form>
</body>
</html>