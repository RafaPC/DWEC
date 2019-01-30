<?php

$triggerReducirNCuentas = "CREATE OR REPLACE TRIGGER decrease_ncuentas_clientes_after_delete_cuentas AFTER DELETE ON cuentas
FOR EACH ROW
UPDATE clientes SET numero_cuentas = numero_cuentas - 1 WHERE dni = OLD.dni1 OR dni = OLD.dni2";

$triggerAumentarNCuentas = "CREATE OR REPLACE TRIGGER increase_ncuentas_clientes_after_delete_cuentas AFTER INSERT ON cuentas
FOR EACH ROW
UPDATE clientes SET numero_cuentas = numero_cuentas + 1 WHERE dni = NEW.dni1 OR dni = NEW.dni2";

$triggerAumentarSaldo = "CREATE OR REPLACE TRIGGER increase_saldo_cuentas_after_insert_movimiento AFTER INSERT ON movimientos
FOR EACH ROW
UPDATE cuentas SET saldo = saldo + NEW.importe WHERE cod_cuenta = NEW.cod_cuenta";

require_once 'constantes_bbdd.php';

try {
    $conex = new PDO(DSN, USER, PASSWORD);
} catch (PDOException $ex) {
    die("Error!: " . $ex->getMessage() . "<br>");
}

//consulta
$conex->query($triggerAumentarNCuentas);
$conex->query($triggerReducirNCuentas);
$conex->query($triggerAumentarSaldo);

//cerrar conex
$conex = null;
?>