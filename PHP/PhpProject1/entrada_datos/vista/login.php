<form method="post" action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>">  
    <input type="text" name="id" value="Nombre">
    <input type="text" name="password" value="Contrasena">
    <input type="submit" name="submit" value="entrar">
    <button type="submit" name="submit" value="registrar1">Registrar</button>
    <?php
    if (isset($error)) {
        echo "<span style=\"color:red;\">$error</span>";
    }
    ?>
</form> 