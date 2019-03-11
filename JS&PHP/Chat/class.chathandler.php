<?php

class ChatHandler {

    //Manda un mensaje que le llegue a todas las conexiones
    function send($mensaje) {
        global $clientSocketArray;
        $messageLength = strlen($mensaje);
        foreach ($clientSocketArray as $clientSocket) {
            //socket_getpeername($clientSocket, $ip);
//            if ($ip == "192.168.103.190") {
//                @socket_write($clientSocket, $message, $messageLength);
//            }

            @socket_write($clientSocket, $mensaje, $messageLength);
        }
        return true;
    }

    //Desempaqueta los datos recibidos
    function unseal($datosSocket) {
        var_dump($datosSocket);
        $length = ord($datosSocket[1]) & 127;
        echo $length;
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
            $datosSocket .= $data[$i] ^ $masks[$i % 4];
        }
        return $datosSocket;
    }

    //Empaqueta el mensaje de una forma u otra dependiendo de su longitud para no perder los datos al mandarlos
    function seal($socketData) {
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
    function doHandshake($headerRecibido, $socketCliente, $nombreHost, $puerto) {
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

    //Crea el mensaje de conexión nueva y lo devuelve en formato json y empaquetado
    function newConnectionACK($ipCliente) {
        $mensaje = 'El usuario ' . $ipCliente . ' se acaba de unir!';
        //$messageArray = array('message' => $message, 'message_type' => 'chat-connection-ack');
        $arrayMensaje = array('mensaje' => $mensaje, 'tipo_mensaje' => 'conexion');
        $ACK = $this->seal(json_encode($arrayMensaje));
        return $ACK;
    }

    function connectionDisconnectACK($ipCliente) {
        $message = 'El usuario ' . $ipCliente . ' se ha desconectado.';
        $arrayMensaje = array('mensaje' => $message, 'tipo_mensaje' => 'desconexion');
        $ACK = $this->seal(json_encode($arrayMensaje));
        return $ACK;
    }

    function createChatBoxMessage($usuario, $mensajeChat, $esAdmin) {
        $mensaje = $mensajeChat;

        //Si la variable recibida $esAdmin está a true, se cambiará el tipo  de mensaje para que tenga una apariencia distinta
        if ($esAdmin) {
            $tipoMensaje = 'mensaje-admin';
        } else {
            $tipoMensaje = 'mensaje';
        }

        $arrayMensaje = array('usuario' => $usuario, 'mensaje' => $mensaje, 'tipo_mensaje' => $tipoMensaje);

        $chatMessage = $this->seal(json_encode($arrayMensaje));
        return $chatMessage;
    }

}

?>