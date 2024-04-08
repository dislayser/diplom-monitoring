<?php
//Конфигурация с ссылками
$domain = 'dislayser';
define('BASE_URL',              $_SERVER['REQUEST_SCHEME'].'://'.$domain.'/');
define('PROFILE_URL',           BASE_URL . 'profile');
define('MONITORING_URL',        BASE_URL . 'monitoring');
define('DEVICES_URL',           BASE_URL . 'devices');
define('LOGIN_URL',             BASE_URL . 'login');
define('LOGOUT_URL',            BASE_URL . 'logout');
define('ADMIN_URL',             BASE_URL . 'admin/');

define('AJAX_PROFILE_URL',      BASE_URL . 'ajax/Profile');

//main path
define('DIR',                    __DIR__."/../../");
?>