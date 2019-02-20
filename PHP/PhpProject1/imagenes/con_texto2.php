<?php
session_start();
$captchaCorrecto = false;
?>
<html>
    <head>
    </head>
    <body>
        <?php
        if (isset($_GET['palabra'])) {
            if ($_SESSION['palabra'] === $_GET['palabra']) {
                $captchaCorrecto = true;
            } else {
                echo "no ha entrado";
            }
        }
        if ($captchaCorrecto) {
            echo '<div>Enhorabuena, no eres un robot.</div>';
        } else {
            ?>
            <form method="get" action ="<?php echo $_SERVER['PHP_SELF']; ?>" >
                <input type="text" name="palabra" value="cosa">
                <input type="submit" name="Mandar">
            </form>
            <img src='con_texto.php' alt='meh' width='350' height="100">
        <?php } ?>
    </body>
</html>

