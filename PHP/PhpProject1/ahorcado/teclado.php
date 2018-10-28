<?php

function iniciar() {
    $abecedario = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
    if (!isset($_SESSION['letrasUtilizadas'])) {
        $_SESSION['letrasUtilizadas'] = array();
        for ($i = 0; $i < 26; $i++) {
            //$letra = $abecedario[$i];
            $_SESSION['letrasUtilizadas'][$abecedario[$i]] = false;
        }
    }
}

function rellenarLetras() {
    //Pongo todas las letras de la palabra a true para que se complete
    $abecedario = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
    for ($i = 0; $i < 26; $i++) {
        $_SESSION['letrasUtilizadas'][$abecedario[$i]] = true;
    }
}

function escribirTeclado($perdido, $ganado) {
    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
        <div id="teclado">
            <div>
                <?php
                $abecedario = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
                for ($i = 0; $i < count($abecedario); $i++) {
                    //Ya que utilizo el for para crear los botones lo utilizo para crear todas las posiciones de $letrasUtilizadas y ponerlas a false
                    $botonUtilizado = false;
                    if ($_SESSION['letrasUtilizadas'][$abecedario[$i]]) {
                        //Se inutiliza el botón
                        $botonUtilizado = true;
                    }
                    if ($i != 0 && $i % 9 == 0) {
                        echo '</div>';
                        echo '<div>';
                    }
                    echo '<button ';
                    if ($botonUtilizado) {
                        echo 'class="botonUtilizado" disabled ';
                    }
                    echo "type=\"submit\" name=\"letra\" value=\"$abecedario[$i]\">$abecedario[$i]</button>";
                }
                echo '</div>';

                if ($perdido || $ganado) {
                    ?>
                    <div><button style="margin-top:20px" type="submit" name="reiniciar" value="Intenttarlo otra vez">Intentarlo otra vez</button></div>
                    <?php
                }
                echo '</div></form>';
            }
            ?>