<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$titulo = 'Crud notas';
require_once '../head.php';
$url = htmlspecialchars($_SERVER["PHP_SELF"]);
session_start();
//session_unset();
require_once '../Conexion/mysqli_.php';
$conex = new ConexionBD();
if (filter_input(INPUT_GET, 'cambiar_nota') !== null) {
    if($conex->cambiarNota($_SESSION['alumno'], $_SESSION['asignatura'], filter_input(INPUT_GET, 'nota'))){
        echo '<h3>Nota cambiada</h3>';
    }else{
        echo '<h3>Error al cambiar la nota</h3>';
    }
}
if (filter_input(INPUT_GET, 'alumno') !== null) {
    $_SESSION['alumno'] = filter_input(INPUT_GET, 'alumno');
} else if (filter_input(INPUT_GET, 'asignatura') !== null) {
    $_SESSION['asignatura'] = filter_input(INPUT_GET, 'asignatura');
}

$consulta = $conex->getAllAlumnos();
$tabla = 'alumno';
require '../tabla.php';
$consulta = $conex->getAllAsignaturas();
$tabla = 'asignatura';
require '../tabla.php';


if (isset($_SESSION['alumno']) && isset($_SESSION['asignatura'])) {
    $nota = $conex->getNota($_SESSION['alumno'], $_SESSION['asignatura']);
    if ($nota === null) {
        echo 'No existe una nota para ese alumno y asignatura.';
    } else {
        $_SESSION['nota'] = $nota;
        ?>
        <form method = "get" action = "<?php echo $url; ?>">
            <input type="number" name="nota" value="<?php echo $nota; ?>" min="0" max="10">
            <div id = "filaBotones">
                <input type="submit" name="cambiar_nota" value="Cambiar Nota">
            </div>
        </form>
        <?php
    }
}
?>

</div>
</body>
</html>