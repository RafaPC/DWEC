<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Ejercicios PHP</title>
        <meta name="author" content="Rafael Prieto Ciprián">
    </head>
    <body>
        <?php
        $nombre = $_POST['nombre'];
        $comentario = $_POST['comment'];
		$man = fopen('datos.txt', 'a');
        fwrite($man,"---------------------------\n".$nombre."\n".$comentario."\n---------------------------"."\n");
        fclose($man);
        ?>
	<h4>Los datos se cargaron correctamente.<br>Pulse <a href="pagina3.php">aqui</a> para ver todo el contenido del fichero.</h4>
    </body>
</html>