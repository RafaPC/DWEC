<?php 
	require_once('head.html');
        if ($resultadoConsulta) {
            ?><table><thead><tr><?php
            foreach ($resultadoConsulta[0] as $clave => $valor) {
                echo "<th style=\"border: 1px solid black\">" . $clave . "</th>";
            }
            ?></tr></thead><?php
            foreach ($resultadoConsulta as $indice => $fila) {
                ?><tbody><tr><?php
                foreach ($fila as $clave => $valor) {
                    echo "<td style=\"border: 1px solid black\">$valor</td>";
                }
                ?></tr><?php
            }
            ?></tbody></table><?php
        }
?>
</body>
</html>