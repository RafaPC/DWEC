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
        require_once 'teclado.php';
        session_start();

        $arrayFotos = ['foto1.png', 'foto2.png', 'foto3.png', 'foto4.png', 'foto5.png', 'foto6.png', 'foto7.png'];
        
        if (!isset($_SESSION['letrasUtilizadas'])) {
            iniciar();
        }
        if (isset($_POST['reiniciar'])) {
            session_unset();
        }
        if (!isset($_SESSION['fotoActual'])) {
            $_SESSION['fotoActual'] = 0;
        }
        if (isset($_POST['enviar'])) {
            $_SESSION['categoria'] = $_POST['categoria'];
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
        } else if (!isset($_SESSION['pa a'])) {
            //Abrir el fichero de la categoria que se ha elegido
            $categoria = $_SESSION['categoria'];
            $arrayPalabras = [];
            //Meter todas las palabras del fichero en un array
            $man = @fopen('ficheros_ahorcado/' . $categoria . '.txt', 'r') or die ('No se ha encontrado el fichero');
            while (!feof($man)) {
                $linea = fgets($man);
                //Como se guardan cada una en una línea en el fichero, si no se hace el trim se quedan con un espacio al final
                $linea = trim($linea);
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
                    echo '</div>';
                    require_once 'teclado.php';
                    escribirTeclado(false,false);
                    echo '</div>';
                } else {
                    if (isset($_POST['letra'])) {
                        $_SESSION['letrasUtilizadas'][$_POST['letra']] = true;
                        $_SESSION['letraElegida'] = $_POST['letra'];

                        $posicionLetra = strpos($_SESSION['palabra'], $_SESSION['letraElegida']);

                        if (!is_numeric($posicionLetra)) {
                            $_SESSION['fotoActual'] ++;
                        }
                    }


                    //Compruebo si ha ganado
                    $contador = 0;
                    $perdido = false; 
                    $ganado = false;
                    $longitudPalabra = strlen(trim($_SESSION['palabra']));
                    for ($i = 0; $i < $longitudPalabra; $i++) {
                        $letraActual = substr($_SESSION['palabra'], $i, 1);
                        if ($_SESSION['letrasUtilizadas'][$letraActual] == true) {
                            $contador++;
                        }
                    }
                    if ($contador === strlen($_SESSION['palabra'])) {
                        echo '<h1>HAS GANADO</h1>';
                        rellenarLetras();
                        $ganado = true;
                    }

                    //Compruebo si ha perdido
                    if ($_SESSION['fotoActual'] === 6) {
                        echo '<h1>HAS PERDIDO</h1>';
                        $perdido = true;
                        rellenarLetras();
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
                        escribirTeclado($perdido, $ganado);
                        ?>
                    </div>
                    <?php
                }
                ?>
                <img src="fotos/<?php echo $arrayFotos[$_SESSION['fotoActual']]; ?>" alt="foto" width="200" height="200"/>
                </body>
                </html>