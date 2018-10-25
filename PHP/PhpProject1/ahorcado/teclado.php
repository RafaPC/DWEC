<?php
$abecedario = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];
if (!isset($_SESSION['letrasUtilizadas'])) {
    $_SESSION['letrasUtilizadas'] = array();
    for ($i = 0; $i < 26; $i++) {
        //$letra = $abecedario[$i];
        $_SESSION['letrasUtilizadas'][$abecedario[$i]] = false;
    }
}

?><form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>"><div>
<?php
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
    ?>
    <!--button name="<?php $abecedario[$i] ?>" onClick="algunaFuncion(<?php $abecedario[$i] ?>)"></button-->
    <?php
}
//echo "<p>name=\"$abecedario[0]\" onclick=\"algunaFuncion(\'$abecedario[0]\')\">$abecedario[0]</p>";

echo '</div></form>';

function algunaFuncion($letra) {

    echo $_SESSION['letrasUtilizadas'][$letra];
    $_SESSION['letrasUtilizadas'][$letra] = true;
    echo $_SESSION['letrasUtilizadas'][$letra];
}
?>