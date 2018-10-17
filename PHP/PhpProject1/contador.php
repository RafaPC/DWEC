<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Ejercicios PHP</title>
        <meta name="author" content="Rafael Prieto Ciprián">
    </head>
    <body>
        <?php
        $contador;
        $man = @fopen('visitas.txt', 'r+') or die('No se ha podido abrir ese fichero');
        $contador = intval(fgets($man));
        echo "<h1>Esta es la visita numero: $contador</h1>";
        $contador++;
        rewind($man);
        fwrite($man, $contador);
        fclose($man);
        ?>
    </body>
</html>