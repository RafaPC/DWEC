<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
require_once '../Conexion/mysqli.php';
$conex = new ConexionBD();
$url = htmlspecialchars($_SERVER["PHP_SELF"]);
$campoElegido = false;
$asignatura = ['ID', 'Nombre', 'Curso', 'Ciclo'];
if (isset($_GET['asignatura']) || isset($_SESSION['asignatura'])) {
    if (isset($_GET['asignatura'])) {
        $_SESSION['asignatura'] = $_GET['asignatura'];
    }
    $campoElegido = true;
    //Hacer funcion de rellenar campos que sirva para notas y alumnos, 
    //puede que me haya flipado y no sea tan viable
}
if (isset($_GET['submit'])) {
    $funcion = $_GET['submit'];
    if ($funcion === 'Crear') {
        $conex->crearAsignatura($_GET['NOMBRE'], $_GET['CURSO'], $_GET['CICLO']);
    } else if ($funcion === 'Actualizar') {
        if (isset($_SESSION['asignatura'])) {
            $conex->updateAsignatura($_GET['ID'], $_GET['NOMBRE'], $_GET['CURSO'], $_GET['CICLO']);
        } else {
            
        }
    } else if ($funcion === 'Borrar') {
        if (isset($_SESSION['asignatura'])) {
            $conex->borrarAsignatura($_GET['ID']);
            unset($_SESSION['asignatura']);
        } else {
            
        }
    }
}
if (isset($_SESSION['asignatura'])) {
    $asignatura = $conex->getAsignatura($_SESSION['asignatura']);
}
$consulta = $conex->getAllAsignaturas();
$titulo = 'Crud asignaturas';
require_once '../head.php';
$tabla = 'asignatura';
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
    <div id="filaInputs">
        <?php
        //No se si al crear se elige el mayor de edad o se mira la fecha y se selecciona solo
        foreach ($asignatura as $clave => $valor) {
            if ($clave === 'ID') {
                echo "<input type=\"text\" name=\"$clave\" value=\"$valor\" id=\"$clave\" readonly=\"readonly\">";
            } else {
                echo "<input type=\"text\" name=\"$clave\" value=\"$valor\" id=\"$clave\">";
            }
        }
        //echo "<input type=\"\"";
        ?>
    </div>
</form>
</div>
</body>
</html>