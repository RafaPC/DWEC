<?php
        ?><table><thead><tr><?php
        foreach ($resultadoConsulta[0] as $clave => $valor) {
			echo "<th>" . $clave . "</th>";
        }
        ?></tr></thead><?php
        foreach ($resultadoConsulta as $indice => $fila) {
            ?><tbody><tr><?php
            foreach ($fila as $clave => $valor) {
                echo "<td>$valor</td>";
            }
			?></tr><?php
        }
		?></tbody></table><?php
    
?>