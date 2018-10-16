<!DOCTYPE html>
<html lang="es">
    <head>
        <link href="newcss.css" rel="stylesheet" type="text/css"/>
        <meta charset="UTF-8">
        <title>Ejercicios PHP</title>
        <meta name="author" content="Rafael Prieto Ciprián">
    </head>
    <body>

        <p>Ejercicio 12<br>
            Crea una página con una tala con dos columnas de un tamaño fijo. Haz que cada vez que se recargue la páginauestre dos colores diferentes. (Uso de una función random en php y la función hsl() para css)</p>
        <?php
        $hue = rand(0, 360);
        $saturation = rand(0, 100);
        $lightness = rand(0, 100);
        $hue2 = rand(0, 360);
        $saturation2 = rand(0, 100);
        $lightness2 = rand(0, 100);
        echo "<table>"
        . "<tr>"
        . "<td style=\"background-color:hsl($hue,$saturation%,$lightness%);width:50px;height:50px\"></td>"
        . "<td style=\"background-color:hsl($hue2,$saturation2%,$lightness2%);width:50px;height:50px\"></td>"
        . "</tr>"
        . "</table>";
        ?>

        <p>13<br>Modifica la página anterior para añadir en una tabla de una sola columna
            el código php que has empleado.</p>		
        <?php
        echo "<table>"
        . "<tr>"
        . "<td>"
        . "<pre>
            &lt?php
	\$hue = rand(0, 360);
        \$saturation = rand(0, 100);
        \$lightness = rand(0, 100);
        \$hue2 = rand(0, 360);
        \$saturation2 = rand(0, 100);
        \$lightness2 = rand(0, 100);
        echo \"&lttable &gt\"
            \"&lttr&gt\"
            \"&lttd style=\"background-color:hsl(\$hue,\$saturation%,\$lightness%);width:50px;height:50px\">&lt/td&gt\"
            \"&lttd style=\"background-color:hsl(\$hue2,\$saturation2%,\$lightness2%);width:50px;height:50px\">&lt/td&gt\"
            \"&lt/tr&gt\"
            \"&lt/table&gt\";
        ?&gt
		</pre>"
        . "</td>"
        . "</tr>"
        . "</table>";
        ?>




        <p>Ejercicio 14 <br> Crea las variables msg1, msg2, msg3 y msg4 con mensajes de texto.
            Obtén un número aleatorio del 1 al 4, accede y muestra el contenido de
            esa variable.</p>		
        <?php
        $arrayMensajes = array('mensaje1', 'mensaje2', 'mensaje3', 'mensaje4');
        $opcion = rand(1, 4);
        echo "array[$opcion]";
        ?>


        <p>Ejercicio 15 <br>Almacene en un array los 10 primeros número pares. Imprímalos cada
            uno en una línea.</p>		
        <?php
        $arrayPares = array();

        $i = 0;
        while (count($arrayPares) < 10) {
            if ($i % 2 == 0) {
                $arrayPares[] = $i;
            }
            $i++;
        }

        foreach ($arrayPares as $valor) {
            echo "$valor <br>";
        }
        ?>

        <p>Ejercicio 16 <br>16.Mostrar una tabla de 4 por 4 que muestre las primeras 4 potencias de
            los números del uno 1 al 4 (hacer una función que las calcule invocando
            la función pow). En PHP las funciones hay que definirlas antes de
            invocarlas.</p>		
        <table>
            <?php
            for ($base = 1; $base <= 4; $base++) {
                echo ('<tr>');
                for ($exponente = 1; $exponente <= 4; $exponente++) {
                    $variable = pow($base, $exponente);
                    echo "<td>$variable</td>";
                }
                echo ('</tr>');
            }
            ?>
        </table>

        <p>Ejercicio 17 <br>17.El diecisiete</p>
        <?php
        $directorio = opendir('fotos');
        $arrayFotos = readdir($directorio);
        var_dump($arrayFotos);
        ?>
        
    </body>
</html>
