<?php

function es_primo($numero) {
    $primo = false;
    for ($i = $numero - 1; $i > 1 && !$primo; $i--) {
        if ($numero == 1 || $numero == 2) {
            $primo = true;
            continue;
        }
        if ($numero % $i == 0) {
            $primo = true;
            continue;
        }
    }
    return $primo;
}

function divisores($numero) {
    for ($i = $numero; $i > 0; $i--) {

        if ($i == 1) {
            echo '1.';
        } else
        if (($numero % $i) == 0) {
            echo "$i, ";
        }
    }
}


function es_primo2($numero){
	$esPrimo = true;
	if($numero==1 || $numero==2){
			$esPrimo = true;
        }else{
			for ($i = $numero - 1; $i > 1; $i--) {
				if ($numero % $i == 0) {
					$esPrimo = false;
					$i==1;
				}
			}
		}
		return $esPrimo;
}

