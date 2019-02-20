<?php
require_once('head.html');
$mostrarLogin = true;
if (isset($_POST['id']) || isset($_POST['pass'])) {
    $usuario->checkUsuario($_POST['id'], $_POST['pass']);
    if ($usuario !== NULL) {
        //Enseñar comentarios de usuario
        $mostrarLogin = false;
    }
}
if ($mostrarLogin) {
    ?>
    <input type="text" name="id" value="Nombre:">
    <input type="text" name="id" value="Contraseña:">
    <?php
}
?>
</body>
</html>