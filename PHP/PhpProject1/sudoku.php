<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Ejercicios PHP</title>
        <meta name="author" content="Rafael Prieto Ciprián">
        <style>
            table tr td{
                border: 1px solid black;
                color: blue;
                font-size: 30px;
                padding: 3px 15px;
                background-color: #cce4fd;
            }
        </style>  
    </head>
    <body>
        <table>
            <?php
            for ($i = 1; $i <= 3; $i++) {
                echo '<tr>';
                for ($j = $i, $contador1 = 0; $contador1 < 3; $j += 3, $contador1++) {
                    echo '<td>';
                    echo '<table>';
                    for ($k = $j, $contador2 = 0; $contador2 < 3; $k += 3, $contador2++) {
                        if ($k > 9) {
                            $k -= 9;
                        }
                        echo '<tr>';
                        for ($z = $k, $contador3 = 0; $contador3 < 3; $z++, $contador3++) {
                            if ($z > 9) {
                                $z -= 9;
                            }
                            echo '<td>';
                            echo "$z";
                            echo '</td>';
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
    </body>
</html>