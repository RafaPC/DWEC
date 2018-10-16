<!DOCTYPE html>
<html lang="es">
    <head>
        <link href="newcss.css" rel="stylesheet" type="text/css"/>
        <meta charset="UTF-8">
        <title>Ejercicios PHP</title>
        <meta name="author" content="Rafael Prieto CipriÃ¡n">
    </head>
    <body>

        <!--Ejercicio 1 -->
        <?php
        // put your code here
        $var1 = 2;
        $var2 = 10;
        $varCambio = $var1;
        $var1 = $var2;
        $var2 = $varCambio;
        echo "<div>$var1</div>"
        ?>

        <br><br>

        <!--Ejercicio 2 -->
        <?php
        $var1 = 2;
        $var2 = 10;
        $varSuma = $var1 + $var2;
        $varResta = $var1 - $var2;
        $varDivision = $var1 / $var2;
        $varProducto = $var1 * $var2;
        echo "<div>Suma = $varSuma</div>";
        echo "<div>Resta = $varResta</div>";
        echo "<div>Producto = $varProducto</div>";
        echo "<div>Division = $varDivision</div>";
        ?>

        <br><br>

        <!--Ejercicio 3 -->
        <?php
        $varNiÃ±os = 12;
        $varNiÃ±as = 13;
        $varTotal = $varNiÃ±os + $varNiÃ±as;
        $varPorcentajeNiÃ±os = $varNiÃ±os * 100 / $varTotal;
        $varPorcentajeNiÃ±as = $varNiÃ±as * 100 / $varTotal;
        echo "<div>Total = $varTotal</div>";
        echo "<div>Porcentaje niÃ±os = $varPorcentajeNiÃ±os %</div>";
        echo "<div>Porcentaje niÃ±as = $varPorcentajeNiÃ±as %</div>";
        ?>

        <br><br>

        <!--Ejercicio 4 -->
        <?php
        $varNumero = 7;
        $varNActual;
        echo "<table>
		<tr>
		<td>Tabla del $varNumero</td>
		</tr>";
        for ($i = 1; $i <= 10; $i++) {
            $varNActual = $varNumero * $i;

            echo "
            <tr>            
            <td>$i</td>
            <td>$varNActual</td>
            </tr >";
        }
        echo "</table>";
        ?>

        <br><br>

        <!--Ejercicio 5 -->
        <?php
        $nombre = "nombre";
        $apellidos = "apellidos";
        $direccion = "direccion";
        $telefono = "608346751";
        echo "<table>"
        . "<tr>"
        . "<td>Nombre</td>"
        . "<td>Apellidos</td>"
        . "<td>Direccion</td>"
        . "<td>Telefono</td>"
        . "</tr>"
        . "<tr>"
        . "<td>$nombre</td>"
        . "<td>$apellidos</td>"
        . "<td>$direccion</td>"
        . "<td>$telefono</td>"
        . "</tr>"
        . "</table>";
        ?>

        <br><br>

        <!--Ejercicio 6 -->
        <?php
        echo "<ol>";
        $arr_canciones = array("cancion1", "cancion2", "cancion3", "cancion4", "cancion5");
        foreach ($arr_canciones as $value) {
            echo "<li>$value</li>";
        }
        echo "</ol>";
        ?>

        <br><br>

        <!-- Ejercicio 9 -->

        <?php
        if (!(defined("MONEDA"))) {
            define("MONEDA", "EURO");
            var_dump(MONEDA);
        }
        ?>


        <br><br>

        <!-- Ejercicio 10 -->

        <?php
        $libro1 = array("titulo" => "titulo1",
            "autor" => "autor1",
            "editorial" => "editorial1",
            "aÃ±o" => 1999,
            "en_prestamo" => true);

        $libro2 = array("titulo" => "titulo2",
            "autor" => "autor2",
            "editorial" => "editorial2",
            "aÃ±o" => 2000,
            "en_prestamo" => false);

        $libro3 = array("titulo" => "titulo3",
            "autor" => "autor3",
            "editorial" => "editorial3",
            "aÃ±o" => 2001,
            "en_prestamo" => true);

        $biblioteca = array($libro1, $libro2, $libro3);

        $librosPrestados = 0;
        foreach ($biblioteca as $libro) {
            $librosPrestados += (int) $libro['en_prestamo'];
        }
        echo "Hay $librosPrestados libros prestados";
        ?>

        <br><br>

        <!-- Ejercicio 11 -->

        <!--?php
        echo "<table>";
        echo "<thead><tr><td>Constante</td><td>Valor</td></tr></thead>";
        foreach (get_defined_constants() as $key => $value) {
            echo "<tr><td>$key</td><td>$value</td></tr>";
        }
        echo "</table>";
        ?-->
    </body>
</html>