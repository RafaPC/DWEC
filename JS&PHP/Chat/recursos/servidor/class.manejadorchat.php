<?php

class ChatHandler {

    //Manda un mensaje a todas las conexiones
    function enviar($mensaje) {
        global $clientSocketArray;
        $messageLength = strlen($mensaje);
        foreach ($clientSocketArray as $clientSocket) {
            @socket_write($clientSocket, $mensaje, $messageLength);
        }
        return true;
    }

    //Desempaqueta los datos recibidos
    //Seguramente sería mejor empaquetar los datos con la función pack(), al igual que se desempaquetan con unpack()
    function desempaquetar($datosSocket) {
        $length = ord($datosSocket[1]) & 127;
        if ($length == 126) {
            $masks = substr($datosSocket, 4, 4);
            $data = substr($datosSocket, 8);
        } elseif ($length == 127) {
            $masks = substr($datosSocket, 10, 4);
            $data = substr($datosSocket, 14);
        } else {
            $masks = substr($datosSocket, 2, 4);
            $data = substr($datosSocket, 6);
        }
        $datosSocket = "";
        for ($i = 0; $i < strlen($data); ++$i) {
            //^ es un operador de bit
            //Concatena a $datosSocket los bits que solo están activados a uno de los lados (solo en $data o $masks, pero no ambos)
            $datosSocket .= $data[$i] ^ $masks[$i % 4];
        }
        
        return $datosSocket;
    }

    //Empaqueta el mensaje de una forma u otra dependiendo de su longitud para no perder datos al mandarlos
    function empaquetar($socketData) {
        $b1 = 0x80 | (0x1 & 0x0f);
        $length = strlen($socketData);

        if ($length <= 125) {
            $header = pack('CC', $b1, $length);
        } else if ($length > 125 && $length < 65536) {
            $header = pack('CCn', $b1, 126, $length);
        } else if ($length >= 65536) {
            $header = pack('CCNN', $b1, 127, $length);
        }
        return $header . $socketData;
    }

    //Escribe en el socket recibido el apretón de manos que se necesita mandar para establecer la conexión
    function hacerApretonDeManos($headerRecibido, $socketCliente, $nombreHost, $puerto) {
        $headers = array();
        //Mete la cabecera recibida en el array $lines, dividida por \r y \n
        $lineas = preg_split("/\r\n/", $headerRecibido);
        //Recorre las lineas del header y recoge las cadenas "Clave: valor."
        foreach ($lineas as $linea) {
            //Quita los espacios en blanco al final del string
            $linea = chop($linea);
            //\A comienzo del sujeto
            //\S cualquier carácter menos espacio en blanco
            //\z final del sujeto
            if (preg_match('/\A(\S+): (.*)\z/', $linea, $matches)) {
                //$matches[1] es el texto que coincide con el primer sub-patrón entre paréntesis capturado
                // o sea (\S+)
                //$matches[2] por tanto es lo que coincide con (.*)
                $headers[$matches[1]] = $matches[2];
            }
        }

        $keySocket = $headers['Sec-WebSocket-Key'];
        //Genera el hash de la clave con el algoritmo sha1
        //Convierte el resultado del paso anterior a una binaria en formato hexadecimal
        //Codifica el resultado del paso anterior en base64
        $secAccept = base64_encode(pack('H*', sha1($keySocket . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')));
        $buffer = "HTTP/1.1 101 Web Socket Protocol Handshake\r\n" .
                "Upgrade: websocket\r\n" .
                "Connection: Upgrade\r\n" .
                "WebSocket-Origin: $nombreHost\r\n" .
                //"WebSocket-Location: ws://$host_name:$port/demo/shout.php\r\n" .
                "WebSocket-Location: ws://$nombreHost:$puerto\r\n" .
                "Sec-WebSocket-Accept:$secAccept\r\n\r\n";
        socket_write($socketCliente, $buffer, strlen($buffer));
    }

    //Crea el mensaje de conexión nueva y lo devuelve en formato json y sellado
    function nuevaConexion($ipCliente) {
        $textoMensaje = 'El usuario ' . $ipCliente . ' se acaba de unir!';
        $arrayMensaje = array('mensaje' => $textoMensaje, 'tipo_mensaje' => 'conexion');
        $mensajeConexion = $this->empaquetar(json_encode($arrayMensaje));
        return $mensajeConexion;
    }
    
    //Crea el mensaje de cierre de conexión y lo devuelve en formato json y sellado
    function cierreConexion($ipCliente) {
        $textoMensaje = 'El usuario ' . $ipCliente . ' se ha desconectado.';
        $arrayMensaje = array('mensaje' => $textoMensaje, 'tipo_mensaje' => 'desconexion');
        $mensajeDesconexion = $this->empaquetar(json_encode($arrayMensaje));
        return $mensajeDesconexion;
    }

    //Crea un mensaje en formato json y lo empaqueta
    function crearMensajeChat($usuario, $textoMensaje, $esAdmin) {
        //Si la variable recibida $esAdmin está a true, se cambiará el tipo  de mensaje para que tenga una apariencia distinta
        if ($esAdmin) {
            $tipoMensaje = 'mensaje-admin';
        } else {
            $tipoMensaje = 'mensaje';
        }

        $arrayMensaje = array('usuario' => $usuario, 'mensaje' => $textoMensaje, 'tipo_mensaje' => $tipoMensaje);
        $mensaje = $this->empaquetar(json_encode($arrayMensaje));
        return $mensaje;
    }
}
?>