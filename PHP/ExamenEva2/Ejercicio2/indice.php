<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
require_once 'conexion.php';
$conecta = new ConectaBD();
$entra = false;
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        if (isset($_COOKIE['nombre'])) {
            if (isset($_POST['cerrarSesion'])) {
                setCookie('nombre', '', 0);
            } else {
                $entra = true;
            }
        } else {
            if (isset($_POST['login'])) {
                if (strlen($_POST['id']) > 0) {
                    if (strlen($_POST['password']) > 0) {
                        $existe = Usuario::checkUsuario(validar($_POST['id']), validar($_POST['password']));
                        if ($existe !== NULL) {
                            if ($existe === TRUE) {
                                //Si entra aquí es que existe y tiene bien la contra
                                if (Usuario::checkValidez(validar($_POST['id']))) {
                                    if (Usuario::checkHorario(validar($_POST['id']))) {
                                        if (Usuario::checkIntentos(validar($_POST['id']))) {
                                            $entra = true;
                                            echo 'bien';
                                        } else {
                                            $error = 'Número de intentos superados';
                                        }
                                    } else {
                                        $error = 'Fuera del horario de trabajo';
                                    }
                                } else {
                                    $error = 'Este usuario ya no tiene validez en el sistema';
                                }
                                //header("Refresh:0");
                            } else if ($existe === FALSE) {
                                $error = 'Contraseña errónea.';
                            }
                        } else {
                            $error = "No existe el usuario.";
                        }
                    } else {
                        $error = 'Introduce contraseña';
                    }
                } else {
                    $error = 'Introduce usuario';
                }
            }
        }
        if (!$entra) {
            ?>
            <form method="post" action="<?php htmlspecialchars($_SERVER['PHP_SELF']);
            ?>">  
                <input type="text"  name="id" value="Nombre">
                <input type="text" name="password" value="Contraseña">
                <input type="submit" name="login" value="entrar">
                <?php
                if (isset($error)) {
                    echo "<span style=\"color:red;\">$error</span>";
                }
                ?>
            </form> 
            <?php
        } else {
            require_once 'bienvenido.php';
        }
        $conecta->cierraConexion();
        ?>
    </body>
</html>
