<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Ejercicios PHP</title>
        <meta name="author" content="Rafael Prieto Ciprián">
    </head>
    <body>
        <form method="post" action="pagina2.php">
            <h1>Sugerencias para nuestra página web</h1>
            <label>Introduzca su nombre: </label>
            <input type="text" name="nombre" value="0">
            <br>
            <label>Comentarios sobre esta pagina web:</label>
            <textarea name="comment" value="0"></textarea>
            <input type="submit" name="enviar" value="procesar">
        </form>
    </body>
</html>