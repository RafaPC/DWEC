<?php
$abecedario = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];
if(!isset($_SESSION['letrasUtilizadas'])){
    $_SESSION['letrasUtilizadas'] = array();
    for($i=0;$i<23;$i++){
        //$letra = $abecedario[$i];
        $_SESSION['letrasUtilziadas'][$abecedario[$i]] = false;
    }
}

echo '<form><div>';
for ($i = 0; $i < count($abecedario); $i++) {
    //Ya que utilizo el for para crear los botones lo utilizo para crear todas las posiciones de $letrasUtilizadas y ponerlas a false
    $botonUtilizado = false;
    if($_SESSION['letrasUtilizadas'][$abecedario[$i]]){
        //Se inutiliza el botón
        $botonUtilizado = true;
    }
    if ($i != 0 && $i % 9 == 0) {
        echo '</div>';
        echo '<div>';
    }
    echo '<button ';
    if($botonUtilizado){
        echo 'class="botonUtilizado"';
    }
    echo "name=\"$abecedario[$i]\" onClick=\"algunaFuncion('$abecedario[$i]')\">$abecedario[$i]</button>";
}
echo '</div></form>';
?>

<?php
function algunaFuncion($letra){
    $_SESSION['letrasUtilizadas'][$letra] = true;
}
?>