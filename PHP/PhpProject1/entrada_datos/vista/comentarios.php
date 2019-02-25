<div style="overflow-y: auto; height: 600px; width: 400px; border: 1px solid black; padding: 30px">
    <?php
    for ($i = 0; $i < count($comentarios); $i++) {
        echo '<div style="width:100%;margin-bottom: 10px;border: 1px dotted red">';
        echo '<span style="display:block;text-align:left; font-weight: bold">';
        echo 'Usuario: ' . $comentarios[$i][2];
        echo '</span>';
        echo $comentarios[$i][0];
        echo '<span style="display:block;text-align: right">';
        echo $comentarios[$i][1];
        echo '</span>';
        echo '</div>';
    }
    ?>
</div>
<form method="post" action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>">
    <textarea name="comentario" value=""></textarea>
    <button type="submit" name="crearComentario" value="crearComentario">Tweet</button>
    <button type="submit" name="salir" value="salir">Salir</button>
</form>