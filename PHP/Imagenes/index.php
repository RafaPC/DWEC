<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
//abrir conexion
        $conex = mysqli_connect("localhost", "root", "1234")
                or die("No se ha podido conectar...");

        mysqli_select_db($conex, "imagenes")
                or die("No se ha podido seleccionar la base de datos");
//        //INSERTAR
        $imagen = dirname(__FILE__) . '/foto.jpg';
        $blob = fopen($imagen, 'rb');
        $binario = addslashes(file_get_contents($imagen));
        //echo '<img src="data:image/jpeg;base64,' . base64_encode($binario) . '" width="300px" height="300px"/>';
        $query = "INSERT INTO `imagenes`(`binario`, `nombre`) VALUES (:imagen,:nombre)";
        $qry = $conex->prepare($query);







//SELECT
//        $consulta = $conex->query("SELECT `binario` FROM `imagenes`;");
//        $binario = $consulta->fetch_all();
//cerrar conex
        mysqli_close($conex);
        ?>
    </body>
</html>
