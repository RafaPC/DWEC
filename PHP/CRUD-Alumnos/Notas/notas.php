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
//$campoElegido = false;
//if (isset($_GET['ID']) || isset($_SESSION['ID'])) {
//    if (isset($_GET['ID'])) {
//        $_SESSION['ID'] = $_GET['ID'];
//    }
//    $campoElegido = true;
//}
if (isset($_GET['submit'])) {
    $funcion = $_GET['submit'];
    if ($funcion === 'Actualizar') {
        $conex->crearAsignatura($_GET['NOMBRE'], $_GET['CURSO'], $_GET['CICLO']);
    }
}
$titulo = 'Crud notas';
require_once '../head.php';
echo '<div>';
$consulta = $conex->getAllFromX('asignaturas');
require '../tabla.php';
$consulta = $conex->getAllFromX('alumnos');
require '../tabla.php';
echo '</div>';
?>
<form method="get" action="<?php echo $url ?>">
    <div id="filaBotones">
        <?php
        echo "<input type=\"submit\" name=\"submit\" value=\"Actualizar\">";
        ?>
    </div>
</form>
</div>
</body>
</html>