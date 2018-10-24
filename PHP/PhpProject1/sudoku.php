<table>
    <?php
    for ($i = 1; $i <= 3; $i++) {
        echo '<tr>';
        for ($j = $i, $contador1 = 0; $contador1 < 3; $j += 3) {
            echo '<td>';
            echo '<table>';
            for ($k = $j, $contador2 = 0; $contador2 < 3; $k += 3) {
                if ($k > 9) {
                    $k -= 9;
                }
                echo '<tr>';
                for ($z = $k, $contador3 = 0; $contador3 < 3; $z++) {
                    if ($z > 9) {
                        $z -= 9;
                    }
                    echo '<td>';
                    $z;
                    echo '<td>';
                }
                echo '</tr>';
            }
            echo '</table>';
            echo '</td>';
        }
        echo '</tr>';
    }
    ?>
</table>