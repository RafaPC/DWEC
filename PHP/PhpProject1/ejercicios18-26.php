<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Ejercicios PHP</title>
        <meta name="author" content="Rafael Prieto Ciprián">
    </head>
    <body>
        <h1>Ejercicio 18 </h1><h3> Hacer un programa que reciba un numero de mes de la url (metodo GET) y
            visualice a que trimestre pertenece o error en caso de que no sea un mes
            valido. Utilizar un switch, con el numero minimo de breaks posibles.</h3>
        <?php 
        if(!isset($_GET['mes'])){
            echo '<p>No se ha recibido el mes</p>';
        }else{
            $mes = $_GET['mes'];         
            switch($mes){
                case 1:
                case 2:
                case 3:
                    echo 'Primer trimestre';
                    break;
                
                case 4:
                case 5:
                case 6:
                    echo 'Segundo trimestre';
                    break;
                
                case 7:
                case 8:
                case 9:
                    echo 'Tercer trimestre';
                    break;
                
                case 10:
                case 11:
                case 12:
                    echo 'Cuarto trimestre';
                    break;
                default:
                    echo 'Mes introducido no valido';
                    break;
            }
        }
        ?>

        <p>------------------------------------</p>
        <h1>Ejercicio 19 </h1><h3> Dado dos numeros, calcular la division entera, comprobando primero que los
            numeros son positivos, que el primero es mayor que el segundo y que el divisor
            es distinto de 0. Dar mensajes de error adecuados en funcion del fallo. Hacer el
            ejercicio utilizando @ y die.</h3>
        <?php
        $dividendo = rand(-5,5);
        $divisor = rand(-5,5);
        
        echo "$dividendo/$divisor<br>";
        
		@($dividendo > 0 && $divisor > 0) or  
        die('Los numeros tienen que ser positivos');
        
		@($dividendo > $divisor) or  
        die('El dividendo tiene que ser mayor que el divisor');
		
		@($divisor !== 0) or
        die('El divisor no puede ser 0');
            
		$resultado = @$dividendo / $divisor;
        echo "Resultado = $resultado";    
        ?>

        <p>------------------------------------</p>
        <h1>Ejercicio 20 </h1><h3> Dados dos numeros calcular el modulo de dos numeros enteros: si el resultado
            es 0, indicar division exacta, si el resultado es 1, indicar sobra 1, si el resultado
            es 2 indicar sobran 2. En cualquier otro caso indicar sobran mas de 2. Utilizar
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
        <h1>Ejercicio 21 </h1><h3> Dado un array inicializado con 10 numeros reales y calcular y visualizar su
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
        <h1>Ejercicio 22 </h1><h3> Utilizando el bucle for y un break. Calcula si un numero es primo o no.
            Nota: Recuerda que un numero es primo si no tiene divisores, en el momento
            en que encuentres un divisor ya no sera primo y podras cortar la ejecucion.</h3>
        <?php
        $numero22 = rand(1, 100);
        echo "<h4>Numero: </h4><p>$numero22</p>";

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
        <h1>Ejercicio 23 </h1><h3> Calcula los divisores de un numero entero positivo.</h3>
        <?php
        $numero23 = rand(1, 100);
        echo "<h4>Numero: </h4><p>$numero23</p>";
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
        <h1>Ejercicio 24 </h1><h3> Dado un par de numeros (ejemplo 7 y 4), y una operacion +, -, * y / (ejemplo
            +), calcular el resultado (ejemplo 11). Utilizar switch.</h3>
        <?php
        $numero24_1 = rand(1, 20);
        $numero24_2 = rand(1, 20);
        $arrayOperaciones = ['+', '-', '*', '/'];
        $operacion = $arrayOperaciones[array_rand($arrayOperaciones)];
        $resultado;
        echo "<p>Numero 1: $numero24_1<br>
		Numero 2: $numero24_2<br>
		Operacion: $operacion</p>";

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
            4) y divisores() (ejercicio5). Realizar una pagina php que incluya este archivo
            funciones.inc, y que haga llamadas a estas funciones del archivo. En concreto
            visualizar los 10 primeros numeross primos.</h3>
        <?php
        include "funciones.inc.php";
		echo 'Numeros primos: ';
		for($i=1,$contador=0;$contador<10;$i++){
		if(es_primo($i)){
		echo "$i, ";
		$contador++;
		}
		}
        ?>

        <p>------------------------------------</p>
        <h1>Ejercicio 26 </h1><h3> Hallar los 20 primeros multiplos de 5 y de 7</h3>
        <h4>Multiplos de 5 y 7: </h4><p>	
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
