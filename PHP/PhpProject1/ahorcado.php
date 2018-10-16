<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Ejercicios PHP</title>
        <meta name="author" content="Rafael Prieto Ciprián">
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
				<div>
                    <h1>Radio</h1>
                    <label>Sexo</label>
                    <input type="radio" name="sexo" value="m" checked>Mujer
                    <input type="radio" name="sexo" value="h">Hombre
                </div>
            </form>
            <?php
        } else {
            ?>	
            <h3>Aquí se accede al fichero seleccionado y se ejecuta toda la vaina</h3>
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
		
		<?php
        $arrayPalabras = [];
        $contador = 0;
		$man = fopen('../ficheros_ahorcado/pelis.txt', 'r');
        while (!feof($man)) {
            $linea = fgets($man);
            if (!empty($linea) && ord($linea) != 13) {
                $contador++;
				array_push($arrayPalabras, $linea);
            }
        }
        fclose($man);
        $numPalabra = rand(0,$contador-1);
		echo "$arrayPalabras[$numPalabra]";
        ?>
    </body>
</html>