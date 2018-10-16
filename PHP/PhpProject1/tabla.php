<!DOCTYPE html>
<html lang="es">
    <head>
        <link href="newcss.css" rel="stylesheet" type="text/css"/>
        <meta charset="UTF-8">
        <title>Ejercicios PHP</title>
        <meta name="author" content="Rafael Prieto CipriÃ¡n">
        <style>
            body      {text-align:center;}
            table {text-align:center; width:550px; background-color: lavender;}
            table th {border:thin inset; width:9%; font-size:18px; font-weight:bold;color:blue;}
            table td {border:thin inset; width:9%;	}
            table .azul {background-color: aqua;}
            table .amarillo {background-color: #F9E79F;}
            .cabecera {font-weight:bold;color:maroon;;}			 
        </style>
    </head>
    <body>

        <?php
        if (!isset($_POST['enviar'])) {
            //enseñar formulario
            ?>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
                <label>Desde el número:</label>
                <input type="text" name="nstart" value="0">
                <br>
                <label>Hasta el número:</label>
                <input type="text" name="nend" value="0">
                <br>
                <input type="submit" name="enviar" value="Ver tabla">
            </form>
            <?php
        } else {
            ?>	
            <h3>28.- Realizar un script PHP que muestre el rango de valores dados por el usuario su tala de multiplicar por los 10 primeros nÃºmeros naturales</h3>
            <?php
            $multiplicandoStart = $_POST['nstart'];
            $multiplicandoEnd = $_POST['nend'];
            $colorAzul = true;
            ?>
            <table>
                <thead>
                <tr>
                    <th class="cabecera">x</th>
                    <?php
                    for ($i = 1; $i <= 10; $i++) {
                        echo "<th>$i</th>";
                    }
                    echo '</tr></thead>';
                    for ($multiplicando = $multiplicandoStart; $multiplicando < $multiplicandoEnd + 1; $multiplicando++) {
                        echo ('<tr>');
                        echo "<td>$multiplicando</td>";
                        for ($multiplicador = 1; $multiplicador < 11; $multiplicador++) {
                            $variable = $multiplicando * $multiplicador;
                            if($colorAzul){
                                echo "<td class=\"azul\">$variable</td>";
                                $colorAzul = false;
                            }else{
                                echo "<td class=\"amarillo\">$variable</td>";
                                $colorAzul = true;
                            }
                        }
                        echo ('</tr>');
                    }
                    ?>
            </table>
        <?php } ?>


    </body>
</html>