<?php
require_once('head.html');
session_start();
//unset($_SESSION['id']);
require_once 'modelo/modelo.php';
$mostrarLogin = true;
$pantallaComentarios = false;
$pantallaRegistro = false;
if (isset($_POST['salir'])) {
    session_destroy();
}
if (isset($_SESSION['id'])) {
    if (isset($_POST['crearComentario'])) {

        Comentarios::insertComentario();
    }
    $comentarios = Comentarios::selectTodos();
    require_once 'vista/comentarios.php';
} else {
    if (isset($_POST['submit'])) {
        if ($_POST['submit'] === 'entrar') {
            $existe = Usuario::checkUsuario($_POST['id'], $_POST['password']);
            if ($existe !== NULL) {
                if ($existe === TRUE) {
                    $mostrarLogin = false;
                    $pantallaComentarios = true;
                    $_SESSION['id'] = $_POST['id'];
                    header("Refresh:0");
                } else if ($existe === FALSE) {
                    $error = 'Contraseña errónea.';
                }
            } else {
                $error = "No existe el usuario.";
            }
        } else if (strcmp($_POST['submit'], "registrar1") === 0) {
            if (Usuario::checkUsuario($_POST['id'], $_POST['password']) === NULL) {
                $pantallaRegistro = true;
                $mostrarLogin = false;
            } else {
                $error = 'Ese usuario ya existe';
            }
        } else if (strcmp($_POST['submit'], "registrar2") === 0) {
            $check = checkDatosRegistro();
            if ($check === TRUE) {
                Usuario::insertUsuario();
                $mostrarLogin = true;
            } else {
                $error = $check;
                $pantallaRegistro = true;
                $mostrarLogin = false;
            }
            //$usuario->insertUsuario($_POST['id'], $_POST['password']);
        }
    }
    if ($mostrarLogin) {
        require_once 'vista/login.php';
    } else if ($pantallaComentarios) {
        $coments = Comentario::selectTodos();
    } else if ($pantallaRegistro) {
        require_once 'vista/registro.php';
    }
}
?>
</body>
</html>