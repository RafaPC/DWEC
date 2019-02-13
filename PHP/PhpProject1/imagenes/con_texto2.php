<?php
session_start();
?>
<html>
    <head>
    </head>
    <body>

        <?php
        if(isset($_GET['palabra'])){
            $_SESSION['palabra'] = $_GET['palabra'];
        }    
        ?>
            <form method="get" action ="<?php echo $_SERVER['PHP_SELF']; ?>" >
                <input type="text" name="palabra" value="cosa">
                <input type="submit" name="Mandar">
            </form>
        <img src='con_texto.php' alt='meh' width='300' height="100">
    </body>
</html>

