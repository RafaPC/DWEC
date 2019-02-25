GRANT USAGE ON *.* TO 'user_entrada'@'%' IDENTIFIED BY PASSWORD '*A4B6157319038724E3560894F7F932C8886EBFCF';

GRANT SELECT, INSERT ON `entrada_datos`.`usuarios` TO 'user_entrada'@'%';

GRANT SELECT, INSERT ON `entrada_datos`.`comentarios` TO 'user_entrada'@'%';