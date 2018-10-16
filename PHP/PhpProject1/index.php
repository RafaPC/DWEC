<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Ejercicios PHP</title>
        <meta name="author" content="Rafael Prieto Ciprián">
    </head>
    <body>


        <p> 1.- Crear una función con paso de parámetros por referencia </p>
        <?php

        //Escribe las tres sílabas de una palabra trisílaba y devuelve la palabra entera
        //Tambien vale si quieres escribir 3 números para formar uno de 3 cifras con ellos
        //Básicamente para cualquier cosa dividida en 3 que quieras juntar

        function funcion_1($prmtr1, $prmtr2, $prmtr3) {
            echo "$prmtr1$prmtr2$prmtr3";
        }

        funcion_1(4, 7, 8);
        echo ('<br>');
        funcion_1('Pé', 'hache', 'pé');
        echo ('<br>');
        ?>
        <p>---------------------------------</p>




        <p>2.- Crear una función con parámetros opcionales</p>
        <?php

        //Si introduces un parámetro te dirá que ese parámetro es su comida preferida
        //Si no, dirá que su comida preferida es la mejor comida del mundo

        function funcion_2($comida = 'unos buenos macarrones con tomatico') {
            echo "Mi comida preferida es $comida";
        }

        funcion_2();
        echo '<br>';
        funcion_2('la paella');
        echo '<br>';
        ?>
        <p>---------------------------------</p>




        <p>3.- Crear una función que utilice las funciones fun_num_args, fun_get_arg, fun_get_args</p>
        <?php
        //Se introducir una serie de números, entonces se dirá la cantidad de números que se han introducido, se mostrarán por separado y luego la suma de ellos
        function funcion_3() {
            $suma = 0;
            $numeros = func_num_args();
            echo "Has introducido $numeros números<br> Los números son: ";
            for ($i = 0; $i < func_num_args(); $i++) {
                $suma += func_get_arg($i);
                echo '<br>';
                echo func_get_arg($i) . "\n";
            }
            echo "<br>La suma es $suma";
        }

        funcion_3(3, 5, 8);
        ?>
        <p>---------------------------------</p>
    </body>
</html>
