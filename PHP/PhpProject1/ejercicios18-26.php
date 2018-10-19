<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Ejercicios PHP</title>
        <meta name="author" content="Rafael Prieto Ciprián">
    </head>
    <body>
        <h1>Ejercicio 18 </h1><h3> Hacer un programa que reciba un número de mes de la url (método GET) y
            visualice a qué trimestre pertenece o error en caso de que no sea un mes
            válido. Utilizar un switch, con el número mínimo de breaks posibles.</h3>
        <?php ?>

        <p>------------------------------------</p>
        <h1>Ejercicio 19 </h1><h3> Dado dos números, calcular la división entera, comprobando primero que los
            números son positivos, que el primero es mayor que el segundo y que el divisor
            es distinto de 0. Dar mensajes de error adecuados en función del fallo. Hacer el
            ejercicio utilizando @ y die.</h3>
        <?php
        //$dividendo = random(-10,10);
        //$divisor = random(-10,10);
        $dividendo = 3;
        $divisor = 1;
        echo "$dividendo./.$divisor";
        
		@($dividendo > 0 && $divisor > 0) or  
        die('Los numero tienen que ser positivos');
        
		@($dividendo > $divisor) or  
        die('El dividendo tiene que ser mayor que el divisor');
		
		($divisor !== 0) or
        die('El divisor no puede ser 0');
            
		$resultado = @$dividendo / $divisor;
        echo "Resultado = $resultado";    
        ?>

        <p>------------------------------------</p>
        <h1>Ejercicio 20 </h1><h3> Dados dos números calcular el módulo de dos números enteros: si el resultado
            es 0, indicar división exacta, si el resultado es 1, indicar sobra 1, si el resultado
            es 2 indicar sobran 2. En cualquier otro caso indicar sobran más de 2. Utilizar
            un switch.</h3>
        <?php
        $num1 = rand(-10, 10);
        $num2 = rand(-10, 10);
        echo "$num1%$num2<br>";
        $resultado = $num1 % $num2;
        switch ($resultado) {
            case 0:
                echo 'Division exacta.';
                break;
            case 1:
                echo 'Sobra uno.';
                break;
            case 2:
                echo 'Sobran dos';
                break;
            default:
                echo 'Sobran mas de dos.';
        }
        ?>

        <p>------------------------------------</p>
        <h1>Ejercicio 21 </h1><h3> Dado un array inicializado con 10 números reales y calcular y visualizar su
            media. (Uso de for)</h3>
        <?php
        $array = array();
        for ($i = 0; $i < 10; $i++) {
            array_push($array, rand(0, 200));
        }
        $total = 0;
        for ($i = 0; $i < 10; $i++) {
            $total += $array[$i];
        }
        $media = $total / 10;
        echo "<p>La media es $media</p>";
        ?>

        <p>------------------------------------</p>
        <h1>Ejercicio 22 </h1><h3> Utilizando el bucle for y un break. Calcula si un número es primo o no.
            Nota: Recuerda que un número es primo si no tiene divisores, en el momento
            en que encuentres un divisor ya no será primo y podrás cortar la ejecución.</h3>
        <?php
        $numero22 = rand(1, 100);
        echo "<h4>Número: </h4><p>$numero22</p>";

        for ($i = $numero22 - 1; $i > 0; $i--) {
            if ($i == 1 || $numero22 == 2) {
                echo '<p>Es primo</p>';
            }
            if ($numero22 % $i == 0) {
                break;
            }
        }
        ?>

        <p>------------------------------------</p>
        <h1>Ejercicio 23 </h1><h3> Calcula los divisores de un número entero positivo.</h3>
        <?php
        $numero23 = rand(1, 100);
        echo "<h4>Número: </h4><p>$numero23</p>";
        echo "<p>Divisores: ";
        for ($i = $numero23; $i > 0; $i--) {

            if ($i == 1) {
                echo '1.';
            } else
            if (($numero23 % $i) == 0) {
                echo "$i, ";
            }
        }
        echo '</p>';
        ?>

        <p>------------------------------------</p>
        <h1>Ejercicio 24 </h1><h3> Dado un par de números (ejemplo 7 y 4), y una operación +, -, * y / (ejemplo
            +), calcular el resultado (ejemplo 11). Utilizar switch.</h3>
        <?php
        $numero24_1 = rand(1, 20);
        $numero24_2 = rand(1, 20);
        $arrayOperaciones = ['+', '-', '*', '/'];
        $operacion = $arrayOperaciones[array_rand($arrayOperaciones)];
        $resultado;
        echo "<p>Número 1: $numero24_1<br>
		Número 2: $numero24_2<br>
		Operación: $operacion</p>";

        switch ($operacion) {

            case "+":
                $resultado = $numero24_1 + $numero24_2;
                break;
            case "-":
                $resultado = $numero24_1 - $numero24_2;
                break;
            case "*":
                $resultado = $numero24_1 * $numero24_2;
                break;
            case "/":
                $resultado = $numero24_1 / $numero24_2;
                break;
        }

        echo "<h4>Resultado: $resultado</h4>";
        ?>

        <p>------------------------------------</p>
        <h1>Ejercicio 25 </h1><h3> En un archivo funciones.inc incluir las funciones definidas es_primo() (ejercicio
            4) y divisores() (ejercicio5). Realizar una página php que incluya este archivo
            funciones.inc, y que haga llamadas a estas funciones del archivo. En concreto
            visualizar los 10 primeros numerous primos.</h3>
        <?php
        include "../inc/funciones.inc.php";
		echo 'Numeros primos: ';
		for($i=1,$contador=0;$contador<10;$i++){
		if(es_primo($i)){
		echo "$i, ";
		$contador++;
		}
		}
        ?>

        <p>------------------------------------</p>
        <h1>Ejercicio 26 </h1><h3> Hallar los 20 primeros múltiplos de 5 y de 7</h3>
        <h4>Múltiplos de 5 y 7: </h4><p>	
                <?php
		$contador;
		for ($i = 5, $contador = 0; $contador < 20; $i++) {
			if ($i % 5 == 0&& $i % 7 == 0) {
				echo "$i, ";
				$contador++;
			}
		}
		
		?>
        </p>

    </body>
</html>
