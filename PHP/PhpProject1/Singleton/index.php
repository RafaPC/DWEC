<?php
require_once('head.html');
require_once('patronSingleton.php');
$conDB = patronSingleton::singleton();
$presentadores = $conDB->getPresentadores();
$conDB::muestra($presentadores);
$invitados = $conDB->getInvitados();
$conDB::muestra($invitados);
?>