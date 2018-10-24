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
                <div>
                    <h1>Radio</h1>
                    <label>Categorias</label>
                    <input type="radio" name="categoria" value="peliculas" checked>Peliculas
                    <input type="radio" name="categoria" value="animales">Animales
                </div>
				<input type="submit" name="enviar" value="Ver tabla">	
            </form>
            <?php
        } else {
            ?>	
            <h3>Aparece el ahorcado con otro form (puede) con un textarea donde poner cada letra</h3>
            <?php
            $multiplicandoStart = $_POST['nstart'];
            $multiplicandoEnd = $_POST['nend'];
            $colorAzul = true;
            ?>
        <?php } ?>
		
		<?php
        $arrayPalabras = [];
		$man = fopen('../ficheros_ahorcado/pelis.txt', 'r');
        while (!feof($man)) {
            $linea = fgets($man);
            if (!empty($linea) && ord($linea) != 13) {
				array_push($arrayPalabras, $linea);
            }
        }
        fclose($man);
        $numPalabra = rand(0,count($arrayPalabras));
		echo "$arrayPalabras[$numPalabra]";
        ?>
    </body>
</html>