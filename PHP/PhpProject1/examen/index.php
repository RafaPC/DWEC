<?php
require_once 'funciones.php';
$errorLogin = false;
$errorPassword = false;
$errorExpiracion = false;
if (isset($_POST['enviar'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];

    $numCodigo = validaUser($login, $password);
    echo $numCodigo;
    switch ($numCodigo) {

        case constant('ERROR_NOREGISTRADO'):
            $errorLogin = true;
            break;
        case constant('ERROR_PASSWORD'):
            $errorPassword = true;
            break;
        case constant('ERROR_EXPIRADO'):
            $errorExpiracion = true;
            break;
        case 1:
        case 2:
            session_start();
            $_SESSION['login'] = $login;
            $_SESSION['tipo'] = $numCodigo;
            //header('Location: ' . "menu.php?login=$login&tipo=$numCodigo");
            header('Location: ' . "menu.php");
            break;
    }
}
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div>
        <div>
            <label>Login:</label>
            <input type="text" name="login" value="">
            <?php if ($errorLogin) echo '<label style="color:red">El login esta mal</label>'; ?>
        </div>
        <div>
            <label>Password</label>
            <input type="password" name="password" value="">
            <?php if ($errorPassword) echo '<label style="color:red">La contraseña esta mal</label>'; ?>
        </div>
        <?php if ($errorExpiracion) echo '<label style="color:red">El usuario ya ha expirado</label>'; ?>

    </div>

    <input type="submit" name="enviar" value="Continuar">
</form>