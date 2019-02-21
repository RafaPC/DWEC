<?php
require_once('head.html');
$mostrarLogin = true;
$pantallaComentarios = false;
$pantallaRegistro = false;
$error = false;
if (isset($_POST['submit'])) {
    require_once 'modelo/modelo.php';
    $usuario = new Usuario();
    if ($_POST['submit'] === 'entrar') {
        $existe = $usuario->checkUsuario($_POST['id'], $_POST['password']);
        if ($existe !== NULL) {
            if ($existe === TRUE) {
                $mostrarLogin = false;
                $pantallaComentarios = true;
                session_start();
                $_SESSION['id'] = $_POST['id'];
            } else if ($existe === FALSE) {
                $error = true;
            }
        }
    } else if ($_POST['submit'] === 'registrar1') {
        if ($usuario->checkUsuario($_POST['id'], $_POST['password']) === NULL) {
            $pantallaRegistro = true;
            $mostrarLogin = false;
        }
    } else if ($_POST['submit'] === "registrar2") {
        if (!checkDatosRegistro()) {
            $usuario->insertUsuario();
        }
        //$usuario->insertUsuario($_POST['id'], $_POST['password']);
    }
}
if ($mostrarLogin) {
    ?>
    <form method="post" action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>">  
        <input type="text" name="id" value="Nombre">
        <input type="text" name="password" value="ContraseÃƒÂ±a">
        <input type="submit" name="submit" value="entrar">
        <button type="submit" name="submit" value="registrar1">Registrar</button>
        <?php if ($error) {
            echo '<span style="color:red;">Error en la contraseÃ±a</span>';
        } ?>
    </form>  
    <?php
} else if ($pantallaComentarios) {
    $comentario = new Comentario();
    $coments = $comentario->selectTodos();
    var_dump($comentario);
} else if ($pantallaRegistro) {
    ?>
    <form method="post" action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>">  
        <input type="text" name="id" value="<?php echo $_POST['id']; ?>" readonly="readonly">
        <input type="text" name="password" value="<?php echo $_POST['password']; ?>" readonly="readonly">
        <input type="text" name="dni" value="dni">
        <input type="text" name="telefono" value="telefono">
        <input type="date" name="fecha_nacimiento" value="">
        <input type="text" name="email" value="email">
        <input type="number" name="saldo" value="0">

        <button type="submit" name="submit" value="registrar2">Registrar</button>
    </form>  

    <?php
}
?>
</body>
</html>