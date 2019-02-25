<div>
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

                        if ($indice % 2 === 0) {
                            $clase = 'oscura';
                        } else {
                            $clase = 'clara';
                        }

                        if (isset($_SESSION[$tabla])) {
                            if ($valor === $_SESSION[$tabla]) {
                                $clase = 'filaElegida';
                            }
                        }

                        echo "<tr class=\"$clase\">";
                    }


                    $id = $fila['ID'];
                    $urlBuena = $url . "?$tabla=$id";
                    echo "<td><a href=\"$urlBuena\">$valor</a></td>";
                }
                ?></tr><?php
            }
            ?></tbody>
    </table>
</div>
