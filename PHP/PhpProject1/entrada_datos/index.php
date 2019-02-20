<?php
require_once('head.html');
$mostrarLogin = true;
$pantallaComentarios = false;
$pantallaRegistro = false;
$errorPass = false;
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
                $errorPass = true;
            }
        }
    } else if ($_POST['submit'] === 'registrar1') {
        $pantallaRegistro = true;
        $mostrarLogin = false;
    } else if ($_POST['registrar'] === "2") {
        checkDatosInput();
        //$usuario->insertUsuario($_POST['id'], $_POST['password']);
    }
}
if ($mostrarLogin) {
    ?>
    <form method="post" action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>">  
        <input type="text" name="id" value="Nombre">
        <input type="text" name="password" value="ContraseÃ±a">
        <input type="submit" name="submit" value="entrar">
        <button type="submit" name="submit" value="registrar1">Registrar</button>
    <?php if ($errorPass) echo '<span style="color:red;">Error en la contraseña</span>'; ?>
    </form>  
        <?php
    }else if ($pantallaComentarios) {
        $comentario = new Comentario();
        $coments = $comentario->selectTodos();
        var_dump($comentario);
    } else if ($pantallaRegistro) {
        ?>
    <input type="text" name="id" value="<?php echo $_POST['id']; ?>" readonly="readonly">
    <input type="text" name="password" value="<?php echo $_POST['password']; ?>" readonly="readonly">
    <input type="text" name="dni" value="dni">
    <input type="text" name="telefono" value="telefono">
    <input type="date" name="fecha_nacimiento" value="">
    <input type="text" name="email" value="email">
    <input type="number" name="saldo" value="0">

    <button type="submit" name="registrar" value="registrar2">Registrar</button>
    <?php
}
?>
</body>
</html>