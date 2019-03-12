<?php

set_time_limit(0);
define('HOST_NAME', "localhost");
define('PORT', "8090");
$null = NULL;
$ipAdmin = gethostbyname(gethostname());
require_once("class.manejadorchat.php");
$manejadorChat = new ChatHandler();

//Crea el socket servidor
$socketServidor = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
//Se puede reutilizar la ip local
socket_set_option($socketServidor, SOL_SOCKET, SO_REUSEADDR, 1);

//Vincula el socket al puerto 8090
socket_bind($socketServidor, 0, PORT);
//Pone el socket a escuchar
socket_listen($socketServidor);

//Hace un array donde se van a guardar los sockets
//El primer socket del array es el del servidor
//Cada vez que se establezca una conexión se introducirá el socket correspondiente en este array
$clientSocketArray[] = $socketServidor;
while (true) {
    //Crea una copia del array de sockets
    $newSocketArray = $clientSocketArray;
    //El primer parametro es un array de sockets, los cuales se checken para ver si alguno tiene una conexión entrante que leer
    //El segundo parámetro checkearía si hay alguna conexión lista para escritura y el tercero para excepciones
    //El cuarto parámetro define el tiempo de espera en segundos
    //El quinto parámetro define el tiempo de espera en microsegundos
    //Por lo tanto, espera 10 microsegundos para ver si hay alguna conexión disponible para leer en los sockets de $newSocketArray
    //Si no hay ninguna dejará $newSocketArray vacío
    //Sin embargo, si $socketResource presenta una conexión para leer, se mantendrá en el array y entrará en el siguiente if
    //Los valores nulos tienen que ser variables porque la función modifica los valores 
    socket_select($newSocketArray, $null, $null, 0, 10);

    //Si se entra en este if es que hay una nueva conexión para $recursoSocket
    if (in_array($socketServidor, $newSocketArray)) {
        //Acepta una conexión del socket servidor y devuelve un socket con esa conexión
        $newSocket = socket_accept($socketServidor);
        //Mete el socket nuevo en el array de sockets de clientes
        $clientSocketArray[] = $newSocket;

        //Lee 1024 bytes de la petición del cliente para coger la cabecera
        $header = socket_read($newSocket, 1024);

        //Escribe el apretón de manos en la nueva conexión
        $manejadorChat->hacerApretonDeManos($header, $newSocket, HOST_NAME, PORT);

        //Le introduce un socket y devuelve en el segundo parámetro el host/puerto
        socket_getpeername($newSocket, $ipCliente);

        //Crea el mensaje de conexión nueva
        $mensajeConexion = $manejadorChat->nuevaConexion($ipCliente);

        $manejadorChat->enviar($mensajeConexion);

        $indiceNuevoSocket = array_search($socketServidor, $newSocketArray);
        //Se quita el nuevo socket para esta iteración ya que no hay nada más que leer en él por ahora
        unset($newSocketArray[$indiceNuevoSocket]);
    }
    //En este punto del programa, $newSocketArray solo contendrá los sockets disponibles para leer
    foreach ($newSocketArray as $newSocketArrayResource) {
        //socket_recv devuelve un número de bytes recibidos o false si da error
        //Solo sigue el loop si se ha recibido al menos un byte de información
        while (socket_recv($newSocketArrayResource, $socketData, 1024, 0) >= 1) {
            //Si hay al menos un byte es que se ha mandado un mensaje
            //Así que hay que *des-sellar* los datos recibidos del socket en socket_recv para no perder datos
            $mensajeSocket = $manejadorChat->desempaquetar($socketData);
            //Una vez dessellados se pasa el texto en formato json a objeto
            $objMensaje = json_decode($mensajeSocket);

            //Miro la ip de la conexión de la que se han leído los datos
            socket_getpeername($newSocketArrayResource, $ip);
            //Miro si la ip es del localhost
            if ($ip === $ipAdmin) {
                $esAdmin = true;
            } else {
                $esAdmin = false;
            }

            $mensajeChat = $manejadorChat->crearMensajeChat($objMensaje->chat_user, $objMensaje->chat_message, $esAdmin);
            $manejadorChat->enviar($mensajeChat);
            //Brake 2 saca la ejecución del while y del for
            break 2;
        }
        if (count($newSocketArrayResource) > 0) {


            //Si devuelve false es que se ha cerrado la conexión
            $socketData = @socket_read($newSocketArrayResource, 1024, PHP_NORMAL_READ);

            //Si se ha desconectado
            if ($socketData === false) {
                die();
                socket_getpeername($newSocketArrayResource, $ipCliente);
                $mensajeDesconexion = $manejadorChat->cierreConexion($ipCliente);
                $manejadorChat->enviar($mensajeDesconexion);
                //Se encuentra el socket desconectado
                $indiceSocket = array_search($newSocketArrayResource, $clientSocketArray);
                //Se borra del array de sockets clientes
                unset($clientSocketArray[$indiceSocket]);
            }
        }
    }
}
socket_close($socketServidor);
?>