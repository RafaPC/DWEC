<table>
    <thead>
        <tr>
            <?php
            foreach ($consulta[0] as $clave => $valor) {
                echo "<th>$clave</th>";
            }
            ?></tr>
    </thead>
    <tbody><?php
        foreach ($consulta as $indice => $fila) {
            if ($indice % 2 === 0) {
                $clase = "oscura";
            } else {
                $clase = "clara";
            }

            foreach ($fila as $clave => $valor) {
                if ($clave === 'ID') {
                    if ($valor === $_GET['ID']) {
                        $clase = 'filaElegida';
                    } else {
                        if ($indice % 2 === 0) {
                            $clase = "oscura";
                        } else {
                            $clase = "clara";
                        }
                    }
                    echo "<tr class=\"$clase\">";
                }


                $id = $fila['ID'];
                $urlBuena = $url . "?ID=$id";
                echo "<td><a href=\"$urlBuena\">$valor</a></td>";
            }
            ?></tr><?php
        }
        ?></tbody>
</table>