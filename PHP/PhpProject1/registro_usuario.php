<!DOCTYPE html>
<html>
    <?php
    include_once "header.php";
    
    $validado = true;
    if (isset($_POST['enviar'])) {
        $nombre = $_POST['username'];
        $contra = $_POST['password'];
        trim($nombre);
        trim($contra);
        if (strlen($nombre) == 0) {
            echo 'Tienes que escribir el nombre';
            $validado = false;
        } else if (strlen($contra) == 0) {
            echo 'Tienes que escribir la contraseÃ±a';
            $validado = false;
        } else if($contra !== 'nohay2sin3'){
            echo 'ContraseÃ±a incorrecta';
            $validado = false;
        }

        if ($validado) {
            session_start();
            $_SESSION['username']=$nombre;
            $_SESSION['password']=$contra;
            include 'usuario_registrado.php';    
        }
    }else{
        $validado = false;
    }
    
    if(!$validado){
    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
        <label>Nombre:</label>
        <input type="text" name="username" value="">
        <label>ContraseÃ±a:</label>
        <input type="password" name="password" value="">
        <input type="submit" name="enviar" value="procesar">
    </form>

    <?php
    }
    ?>
</html>