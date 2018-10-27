<?php
$abecedario = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];
if (!isset($_SESSION['letrasUtilizadas'])) {
    $_SESSION['letrasUtilizadas'] = array();
    for ($i = 0; $i < 26; $i++) {
        //$letra = $abecedario[$i];
        $_SESSION['letrasUtilizadas'][$abecedario[$i]] = false;
    }
}
?>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>"><div id="teclado"><div>
            <?php
            for ($i = 0; $i < count($abecedario); $i++) {
                //Ya que utilizo el for para crear los botones lo utilizo para crear todas las posiciones de $letrasUtilizadas y ponerlas a false
                $botonUtilizado = false;
                if ($_SESSION['letrasUtilizadas'][$abecedario[$i]]) {
                    //Se inutiliza el botÃ³n
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
                ?>
                <?php
            }
//echo "<p>name=\"$abecedario[0]\" onclick=\"algunaFuncion(\'$abecedario[0]\')\">$abecedario[0]</p>";
            ?>
        </div>
        <?php
        if ($_SESSION['perdido']) {
            ?>
            <div><button style="margin-top:20px" type="submit" name="reiniciar" value="Intenttarlo otra vez">Intentarlo otra vez</button></div>
            <?php
        }
        ?>
    </div>
</form>