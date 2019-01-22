<?php
if ($resultadoConsulta) {
    foreach ($resultadoConsulta as $indice => $fila) {
        foreach ($fila as $clave => $valor) {
            $valor = $fila[$clave];
            $claveBuena = strtoupper($clave);
            echo "$claveBuena: $valor  - ";
        }
        echo "</br>";
    }
}
?>
</body>
</html>