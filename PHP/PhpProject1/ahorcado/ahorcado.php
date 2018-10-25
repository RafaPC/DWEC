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
        session_start();
        if (isset($_POST['enviar'])) {
            echo "Esto solo deberia aparecer al elegir categoria";
            $_SESSION['categoria'] = $_POST['categoria'];
            echo var_dump($_POST);
        }
        ?>
        <h1>AHORCADO</h1>
        <img src="020384.jpg" alt="foto" width="200" height="200"/>
        <?php
        if (!isset($_SESSION['categoria'])) {
            ?>
            //Sustituir por un include del formulario
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
            echo $categoria;
            $arrayPalabras = [];
            //aqui poner ../ficheros_ahorcado
            //Meter todas las palabras del fichero en un array
            //$man = fopen($categoria . '.txt', 'r');
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
            echo count($arrayPalabras);
            $palabra = $arrayPalabras[rand(0, count($arrayPalabras) - 1)];
            $_SESSION['palabra'] = $palabra;
            //header('Location: ' . htmlspecialchars($_SERVER["PHP_SELF"]));
            //$longitudPalabra = strlen(trim($palabra));

            include 'teclado.php';
        } else {
            $abecedario = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];

            //Coger el carácter que se haya utilizado y completarlo en la palabra si existe
            if (isset($_POST['letra'])) {
                $_SESSION['letrasUtilizadas'][$_POST['letra']] = true;
                $_SESSION['letraElegida'] = $_POST['letra'];
            }

            //Coger la longitud y eso para escribir todos los huecos
            $longitudPalabra = strlen(trim($_SESSION['palabra']));
            echo '<div id="palabra">';
            $posicionUltimaLetra = -1;
            for ($i = 0; $i < $longitudPalabra; $i++) {
                ?>
                <span class="caracterPalabra">
                    <?php
                    //Por cada caracter recorre el array de letras utilizadas por si alguna coincide
                    //Saco el caracter actual de la palabra
                    $letraActual = substr($_SESSION['palabra'], $i, 1);
                    for ($i = 0, $encontrada = false; $encontrada == false && $i < count($_SESSION['letrasUtilizadas']) - 1; $i++) {

                        //ESTO SE BUGEA MUCHISIMO
                        if (($_SESSION['letrasUtilizadas'][$abecedario[$i]]) == $letraActual) {
                            echo ($_SESSION['letrasUtilizadas'][$abecedario[$i]]);
                            $encontrada = true;
                        }
                    }
                    $posicionLetra = strpos($_SESSION['palabra'], $_SESSION['letraElegida'], $i);
                    if (is_numeric($posicionLetra)) {
                        echo $_SESSION['letraElegida'];
                    }
                    ?>
                </span>
                <?php
            }
            echo '</div>';
            include 'teclado.php';
        }
        ?>
    </body>
</html>