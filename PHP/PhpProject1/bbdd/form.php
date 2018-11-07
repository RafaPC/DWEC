<?php
//$mensajeNombre = "";
$errorNombre = false;
//$mensajeContra = "";
$errorContra = false;
$sacarForm = true;
$repetido = false;
$usuarioExiste = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $repetido = true;
    $sacarForm = false;
    $nombre = $_POST['nombre'];
    $contraseña = $_POST['contraseña'];
    require('../inc/filtrado.php');
    if (!filtrado($nombre)) {
        $mensajeNombre = 'El nombre tiene que ser válido';
        $errorNombre = true;
        $sacarForm = true;
    }
    if (!filtrado($contraseña)) {
        $mensajeContra = 'La contraseña tiene que ser válido';
        $errorContra = true;
        $sacarForm = true;
    }
    if (!$errorNombre && !$errorContra) {
        //abrir conexion
        $conex = mysqli_connect("localhost", "root", "1234")
                or die("No se ha podido conectar...");

        mysqli_select_db($conex, "dwes")
                or die("No se ha podido seleccionar la base de datos");
        //consulta
        $consulta = mysqli_query($conex, "SELECT * FROM usuarios WHERE login = '$nombre'");
        $numFilas = mysqli_num_rows($consulta);

        if ($numFilas >= 1) {
            $usuarioExiste = true;
            $sacarForm = true;
        } else {
            $consulta = mysqli_query($conex, "INSERT INTO `usuarios` (`login`, `clave`) VALUES ('$nombre', '$contraseña');");
            $numFilas = mysqli_num_rows($consulta);
            if ($numFilas === 1) {
                echo '<h1>Todo OK :)</h1>';
            }
        }

        //cerrar conex
        mysqli_close($conex);

        /* //abrir conexion
          $conex = mysqli_connect("localhost", "root", "1234")
          or die("No se ha podido conectar...");

          mysqli_select_db($conex, "dwes")
          or die("No se ha podido seleccionar la base de datos");
          //consulta
          $consulta = mysqli_query($conex, "select * from usuarios");
          $numFilas = mysqli_num_rows($consulta);
          $fila = mysqli_fetch_array($consulta);
          echo '<pre>';
          print_r($fila);
          echo '</pre>';
          echo $numFilas;

          //cerrar conex
          mysqli_close($conex);
         */
    }
}
if ($sacarForm) {
    ?>
    <form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <h1>Nombre de usuario:</h1>
        <?php
        if ($usuarioExiste) {
            echo '<h1>El usuario introducido ya existe</h1>';
        }
        if ($errorNombre) {
            echo '<label>El nombre tiene que ser valido</label>';
        }
        ?>
        <input type="text" name="nombre" value="">

        <h1>Contraseña</h1>
        <?php
        if ($errorContra) {
            echo '<label>La contraseña tiene que ser valida</label>';
        }
        ?>
        <input type="password" name="contraseña" value="">

        <input type="submit" name="enviar" value="Enviar">
    </form>
    <?php
}
?>