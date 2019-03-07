GRANT USAGE ON *.* TO 'banquero'@'localhost' IDENTIFIED BY PASSWORD '*A4B6157319038724E3560894F7F932C8886EBFCF';

GRANT SELECT, INSERT ON `banco`.`clientes` TO 'banquero'@'localhost';

GRANT SELECT, INSERT ON `banco`.`movimientos` TO 'banquero'@'localhost';

GRANT SELECT, INSERT, UPDATE ON `banco`.`cuentas` TO 'banquero'@'localhost';