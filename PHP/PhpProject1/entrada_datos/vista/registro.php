<form method="post" action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>">  
    <input type="text" name="id" value="<?php echo $_POST['id']; ?>" readonly="readonly">
    <input type="text" name="password" value="<?php echo $_POST['password']; ?>" readonly="readonly">
    <input type="text" name="dni" value="dni">
    <input type="text" name="telefono" value="telefono">
    <input type="date" name="fecha_nacimiento" value="">
    <input type="text" name="email" value="email">
    <input type="number" name="saldo" value="0">

    <button type="submit" name="submit" value="registrar2">Registrar</button>
    <?php
    if (isset($error)) {
        echo "<span style=\"color:red;\">$error</span>";
    }
    ?>
</form>