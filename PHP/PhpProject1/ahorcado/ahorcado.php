<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Ejercicios PHP</title>
        <meta name="author" content="Rafael Prieto CipriÃƒÂ¡n">
        <link href="cssahorcado.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php
        $arrayFotos = ['foto1.png', 'foto2.png', 'foto3.png', 'foto4.png', 'foto5.png', 'foto6.png', 'foto7.png'];
        session_start();
        if(isset($_POST['reiniciar'])){
            session_unset();
        }
        if (!isset($_SESSION['fotoActual'])) {
            $_SESSION['fotoActual'] = 0;
        }
        if (isset($_POST['enviar'])) {
            $_SESSION['categoria'] = $_POST['categoria'];
        }
        if (!isset($_SESSION['perdido'])) {
            $_SESSION['perdido'] = false;
        }
        ?>
        <h1>AHORCADO</h1>
        <?php
        if (!isset($_SESSION['categoria'])) {
            //Sustituir por un include del formulario
            ?> 
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">        
                <div id="categorias">
                    <p>Categorias</p>
                    <div class="input">
                        <input type="radio" name="categoria" value="peliculas" checked>Peliculas
                    </div>
                    <div class="input">
                        <input type="radio" name="categoria" value="animales">Animales
                    </div>
                    <div><input type="submit" name="enviar" value="Enviar"></div>
                </div>
            </form>
            <?php
        } else if (!isset($_SESSION['palabra'])) {
            //Abrir el fichero de la categoria que se ha elegido
            $categoria = $_SESSION['categoria'];
            $arrayPalabras = [];
            //Meter todas las palabras del fichero en un array
            $man = fopen('ficheros_ahorcado/' . $categoria . '.txt', 'r');
            while (!feof($man)) {
                $linea = fgets($man);
                if (!empty($linea) && ord($linea) != 13) {
                    array_push($arrayPalabras, $linea);
                }
            }
            fclose($man);
            //Escoger una palabra aleatoria
            $palabra = $arrayPalabras[rand(0, count($arrayPalabras) - 1)];
            $_SESSION['palabra'] = $palabra;
            $longitudPalabra = strlen(trim($palabra));
            ?>
            <div id="palabrayteclado">
                <div id="palabra">
                    <?php
                    for ($i = 0; $i < $longitudPalabra; $i++) {
                        ?>
                        <span class="caracterPalabra">
                        </span>
                        <?php
                    }
                    ?>
                </div>
                <?php
                include 'teclado.php';
                ?>
            </div>
            <?php
        } else {
            if (isset($_POST['letra'])) {
                $_SESSION['letrasUtilizadas'][$_POST['letra']] = true;
                $_SESSION['letraElegida'] = $_POST['letra'];

                $posicionLetra = strpos($_SESSION['palabra'], $_SESSION['letraElegida']);

                if (!is_numeric($posicionLetra)) {
                    $_SESSION['fotoActual'] ++;
                }
            }

            $perdido = false;
            if ($_SESSION['fotoActual'] === 6) {
                $_SESSION['perdido'] = true;
                //Pongo todas las letras de la palabra a true para que se complete
                $abecedario = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];
                for ($i = 0; $i < 26; $i++) {
                    $_SESSION['letrasUtilizadas'][$abecedario[$i]] = true;
                }
            }
//Coger el carÃ¡cter que se haya utilizado y completarlo en la palabra si existe

            echo 'Foto actual = ' . $_SESSION['fotoActual'];
            //Coger la longitud y eso para escribir todos los huecos
            $longitudPalabra = strlen(trim($_SESSION['palabra']));
            echo 'Foto = ' . $_SESSION['fotoActual'];
            if ($perdido) {
                echo '<h1>HAS PERDIDO</h1>';
            }
            ?>

            <div id="palabrayteclado">
                <div id="palabra">
                    <?php
                    for ($i = 0; $i < $longitudPalabra; $i++) {
                        ?>
                        <span class="caracterPalabra">
                            <?php
                            //Por cada caracter recorre el array de letras utilizadas por si alguna coincide
                            //Saco el caracter actual de la palabra
                            $letraActual = substr($_SESSION['palabra'], $i, 1);
                            if ($_SESSION['letrasUtilizadas'][$letraActual] == true) {
                                echo "$letraActual";
                            }
                            ?>
                        </span>
                        <?php
                    }
                    ?></div><?php
                include 'teclado.php';
                ?>
            </div>
            <?php
        }
        ?>
        <img src="fotos/<?php echo $arrayFotos[$_SESSION['fotoActual']]; ?>" alt="foto" width="200" height="200"/>
    </body>
</html>