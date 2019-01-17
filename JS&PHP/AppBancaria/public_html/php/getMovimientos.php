<?php
	$myObj = new stdClass();
	$myObj->resultado = null;
	$ncuenta = $_POST['numcuenta'];
    $prueba1 = strtotime(strtr($_POST['fecha1'],'/','-'));
    $prueba2 = strtotime(strtr($_POST['fecha2'],'/','-'));
    $fecha1 = date("Y-m-d",$prueba1);
    $fecha2 = date("Y-m-d",$prueba2);  
    $sql = "SELECT * FROM `movimientos` WHERE (mo_fec BETWEEN '$fecha1' AND '$fecha2') AND (mo_ncuenta = '$ncuenta')";
    //abrir conexion
$dsn = "mysql:host=localhost;dbname=banco;charset=UTF8";
try{
    $conex = new PDO($dsn,'root','1234');   
}catch(PDOException $ex){
    die("¡Error!: " . $ex->getMessage()."<br>");
}
    //consulta
    $result = $conex->query($sql);
    $filas = array();
            $result->setFetchMode(PDO::FETCH_ASSOC);
            while ($r = $result->fetch()) {
                $filas[] = $r;
            }
    $myObj->resultado = $filas;
	$myJSON = json_encode($myObj);
	echo $myJSON;

    //cerrar conex
    $conex = null;
?>