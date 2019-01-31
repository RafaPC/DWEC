<?php

$triggerReducirNCuentas = "CREATE OR REPLACE TRIGGER decrease_ncuentas_clientes_after_delete_cuentas AFTER DELETE ON cuentas
FOR EACH ROW
UPDATE clientes SET numero_cuentas = numero_cuentas - 1 WHERE dni = OLD.dni1 OR dni = OLD.dni2";

$triggerAumentarNCuentas = "CREATE OR REPLACE TRIGGER increase_ncuentas_clientes_after_delete_cuentas AFTER INSERT ON cuentas
FOR EACH ROW
UPDATE clientes SET numero_cuentas = numero_cuentas + 1 WHERE dni = NEW.dni1 OR dni = NEW.dni2";

$triggerAumentarSaldoCuenta = "CREATE OR REPLACE TRIGGER update_saldo_cuentas_after_insert_movimiento AFTER INSERT ON movimientos
FOR EACH ROW
UPDATE cuentas SET saldo = saldo + NEW.importe WHERE cod_cuenta = NEW.cod_cuenta";

$triggerAumentarSaldoCliente = "CREATE OR REPLACE TRIGGER update_saldo_clientes_after_update_cuenta AFTER UPDATE ON cuentas
FOR EACH ROW
UPDATE clientes SET saldo = saldo + (NEW.saldo - OLD.saldo) WHERE dni = NEW.dni1 or dni = NEW.dni2";

$triggerDeleteMovimientos = "CREATE OR REPLACE TRIGGER delete_movimientos_before_delete_cuentas BEFORE DELETE ON cuentas
FOR EACH ROW
DELETE FROM movimientos WHERE cod_cuenta = OLD.cod_cuenta";


$triggerDeleteClientes = "CREATE OR REPLACE TRIGGER delete_clientes_after_update AFTER UPDATE ON clientes
FOR EACH ROW
DELETE FROM clientes WHERE numero_cuentas = 0";
//#1235 - Esta versión de MariaDB no soporta todavia 'multiple triggers with the same action time and event for one table'
$triggerReducirSaldoCuenta = "CREATE OR REPLACE TRIGGER update_saldo_clientes_after_delete_cuenta AFTER DELETE ON cuentas
FOR EACH ROW
UPDATE clientes SET saldo = saldo - OLD.saldo WHERE dni = OLD.dni1 or dni = OLD.dni2";

require_once 'constantes_bbdd.php';

try {
    $conex = new PDO(DSN, USER, PASSWORD);
} catch (PDOException $ex) {
    die("Error!: " . $ex->getMessage() . "<br>");
}

//consulta
$conex->query($triggerAumentarNCuentas);
$conex->query($triggerReducirNCuentas);
$conex->query($triggerAumentarSaldoCuenta);
$conex->query($triggerAumentarSaldoCliente);
$conex->query($triggerDeleteMovimientos);
//$conex->query($triggerDeleteClientes);
//cerrar conex
$conex = null;
?>