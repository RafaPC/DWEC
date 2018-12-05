<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Ejercicios PHP</title>
        <meta name="author" content="Rafael Prieto Ciprián">
    </head>
    <body>
        <div>
            <?php
            $man = fopen('datos.txt', 'r');
            while (!feof($man)) {
                $linea = fgets($man);
                if (!empty($linea) && ord($linea) != 13) {
                    echo "$linea" . "<br>";
                }
            }
            fclose($man);
            ?>
        </div>
    </body>
</html>