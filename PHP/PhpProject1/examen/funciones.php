<?php

define('ADMINISTRADOR', 1);
define('REGISTRADO', 2);


define('ERROR_NOREGISTRADO', -1);
define('ERROR_PASSWORD', -2);
define('ERROR_EXPIRADO', -3);

$usuarios = [[]];
$usuarios['rafa'] = ['contrasena' => 'nohay2sin3', 'fecha_exp' => time()+800, 'tipo_user' => constant('ADMINISTRADOR')];
$usuarios['estenopasa'] = ['contrasena' => 'daigual', 'fecha_exp' => mktime(0, 0, 0, 1, 1, 2018), 'tipo_user' => constant('REGISTRADO')];
$usuarios['usuarionormal'] = ['contrasena' => 'contraseñanormal', 'fecha_exp' => time()+800, 'tipo_user' => constant('REGISTRADO')];

function validaUser($login, $contrasena) {
    //PALUEGO
    //$user = [$login => [$contrasena => '']];
    //$usuarios[$login[$contrasena]] = 'contrasena';
    global $usuarios;
	if (array_key_exists($login, $usuarios)) {
        //Una forma
        if ($usuarios[$login]['contrasena'] === $contrasena) {
            if ($usuarios[$login]['fecha_exp'] > time()) {
                return $usuarios[$login]['tipo_user'];
            } else {
                return constant('ERROR_EXPIRADO');
            }
        } else {
            return constant('ERROR_PASSWORD');
        }
    } else {
        return constant('ERROR_NOREGISTRADO');
    }
}
