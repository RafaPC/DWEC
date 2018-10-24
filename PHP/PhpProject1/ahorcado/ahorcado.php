<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Ejercicios PHP</title>
        <meta name="author" content="Rafael Prieto CipriÃ¡n">
        <link href="cssahorcado.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php
        if (isset($_POST['enviar'])) {
            $_SESSION['categoria'] = $_POST['categoria'];
        }
        ?>
        <h1>AHORCADO</h1>
        <img src="020384.jpg" alt="foto" width="200" height="200"/>
        <?php
        if (!isset($_SESSION['categoria'])) {
            ?>

            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">        
                <div id="categorias">
                    <h2>Categorias</h2>
                    <input type="radio" name="categoria" value="peliculas" checked>Peliculas
                    <input type="radio" name="categoria" value="animales">Animales
                    <div><input type="submit" name="enviar" value="Enviar"></div>
                </div>
            </form>
            <?php
        } else if (!isset($_SESSION['palabra'])) {
            
            //Abrir el fichero de la categoria que se ha elegido
            $categoria = $_SESSION['categoria'];
            $arrayPalabras = [];
            //aqui poner ../ficheros_ahorcado
            
            //Meter todas las palabras del fichero en un array
            //$man = fopen($categoria . '.txt', 'a');
            $man = fopen('peliculas.txt', 'r');
            while (!feof($man)) {
                $linea = fgets($man);
                if (!empty($linea) && ord($linea) != 13) {
                    array_push($arrayPalabras, $linea);
                }
            }
            fclose($man);
            //$numPalabra = rand(0, count($arrayPalabras));
            //Escoger una palabra aleatoria
            $palabra = $arrayPalabras[rand(0, count($arrayPalabras))];
            $_SESSION['palabra'] = $palabra;
            //header('Location: ' . htmlspecialchars($_SERVER["PHP_SELF"]));

            $longitudPalabra = strlen(trim($palabra));
            echo '<div id="palabra">';
            for ($i = 0; $i < $longitudPalabra; $i++) {
                ?>
                <span class="caracterPalabra"></span>
                <?php
            }
            echo '</div>';
            include 'teclado.php';
        }
        ?>
    </body>
</html>