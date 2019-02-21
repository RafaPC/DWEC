<?php
require_once('head.html');
session_start();
//unset($_SESSION['id']);
require_once 'modelo/modelo.php';
$mostrarLogin = true;
$pantallaComentarios = false;
$pantallaRegistro = false;
if (isset($_SESSION['id'])) {
    if(isset($_POST['crearComentario'])){
        
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
        } else if ($_POST['submit'] === 'registrar1') {
            if (Usuario::checkUsuario($_POST['id'], $_POST['password']) === NULL) {
                $pantallaRegistro = true;
                $mostrarLogin = false;
            }
        } else if ($_POST['submit'] === "registrar2") {
            if (!checkDatosRegistro()) {
                Usuario::insertUsuario();
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
            <?php
            if (isset($error)) {
                echo "<span style=\"color:red;\">$error</span>";
            }
            ?>
        </form>  
        <?php
    } else if ($pantallaComentarios) {
        $comentario = new Comentario();
        $coments = $comentario->selectTodos();
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
}
?>
</body>
</html>