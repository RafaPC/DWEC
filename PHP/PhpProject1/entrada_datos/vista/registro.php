<form method="post" action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>">  
    <label for="nombre">Nombre</label>
    <input type="text" name="id" value="<?php echo $_POST['id']; ?>" readonly="readonly" id="nombre">
    <label for="password">Password</label>
    <input type="text" name="password" value="<?php echo $_POST['password']; ?>" readonly="readonly" id="password">
    <label for="dni">DNI</label>
    <input type="text" name="dni" value="<?php
    if (isset($_POST['dni'])) {
        echo $_POST['dni'];
    } else {
        echo 'dni';
    }
    ?>" id="dni">
    <label for="telefono">Teléfono fijo</label>
    <input type="text" name="telefono" value="<?php
    if (isset($_POST['telefono'])) {
        echo $_POST['telefono'];
    } else {
        echo 'telefono';
    }
    ?>" id="telefono">
    <label for="fecha">Fecha de nacimiento</label>
    <input type="date" name="fecha_nacimiento" value="<?php
    if (isset($_POST['fecha_nacimiento'])) {
        echo $_POST['fecha_nacimiento'];
    } else {
        echo 'fecha_nacimiento';
    }
    ?>" id="fecha">
    <label for="email">Email</label>
    <input type="text" name="email" value="<?php
    if (isset($_POST['email'])) {
        echo $_POST['email'];
    } else {
        echo 'email';
    }
    ?>" id="email">
    <label for="saldo">Saldo</label>
    <input type="number" name="saldo" value="0" id="saldo">

    <button type="submit" name="submit" value="registrar2">Registrar</button>
    <?php
    if (isset($error)) {
        echo "<span style=\"color:red;\">$error</span>";
    }
    ?>
</form>