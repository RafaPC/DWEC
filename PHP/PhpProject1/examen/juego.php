<?php
require_once('clases.php');
session_start();
$carta = new Carta('ORO',1);
echo $carta->puntos();

if (!isset($_SESSION['login'])) {
    echo mb_convert_encoding('<h1>&#9760;', 'UTF-8', 'HTML-ENTITIES');
    echo ' No tienes acceso a esta pagina, <a href="index.php">vuelve</a> por donde has venido';
    echo mb_convert_encoding('&#9760;', 'UTF-8', 'HTML-ENTITIES') . '</h1>';
} else {
    if (!isset($_SESSION['baraja'])) {
        $_SESSION['baraja'] = new Baraja();
        $_SESSION['baraja']->barajar();
        $_SESSION['puntosUsuario'] = 0;
        $_SESSION['puntosMaquina'] = 0;
		
    }
    ?>
    <!DOCTYPE html>
    <html lang="es">
        <head>
            <title>Juego</title>
        </head>
        <body>
            <?php
			echo 'Puntos usuario: ' . $_SESSION['puntosUsuario'];
            echo 'Puntos maquina: ' . $_SESSION['puntosMaquina'];
            echo '<br>';
            if (isset($_GET['cartaSacada'])) {
                //Cada jugador saca carta
                $cartaUsuario = $_SESSION['baraja']->sacarCarta();
                $cartaMaquina = $_SESSION['baraja']->sacarCarta();

                
				if($cartaUsuario == null){
				if($_SESSION['puntosUsuario']>$_SESSION['puntosMaquina']){
					echo 'Has ganado';
				} else if($_SESSION['puntosUsuario']<$_SESSION['puntosMaquina']){
					echo 'Has perdido';
				}else{
					echo 'Empate';
				}
						
				}else{
					echo '<div><div>' . $_SESSION['login'] . '</div>';
                $cartaUsuario->imprime();
                echo '</div>';

                echo '<div><div>' . 'MI PC' . '</div>';
                $cartaMaquina->imprime();
                echo '</div>';
					
					if($cartaUsuario->puntos() > $cartaMaquina->puntos()) {
						echo 'Punto para ' . $_SESSION['login'];
						$_SESSION['puntosUsuario']++;
					}else if($cartaUsuario->puntos() < $cartaMaquina->puntos()){
						echo 'Punto para MI PC';
						$_SESSION['puntosMaquina']++;
					}else{
						echo 'EMPATE';
					}
				}
            }
            ?>
            <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                <input type="submit" name="cartaSacada" value="SACAR CARTA">
            </form>
        </body>    
    </html>
    <?php
}