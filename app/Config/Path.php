<?php
//main path
define('DIR',                    __DIR__."/../../");
define('ROOT_AMPPS',             __DIR__."/../../../");
//Конфигурация с ссылками
$domain = 'gastrack.opfobos.ru';
define('BASE_URL',              $_SERVER['REQUEST_SCHEME'].'://'.$domain.'/');
define('PROFILE_URL',           BASE_URL . 'profile');
define('MONITORING_URL',        BASE_URL . 'monitoring');
define('DEVICES_URL',           BASE_URL . 'devices');
define('LOGIN_URL',             BASE_URL . 'login');
define('LOGOUT_URL',            BASE_URL . 'logout');
define('ADMIN_URL',             BASE_URL . 'admin/');

define('API_URL',               BASE_URL . 'api/');
define('AJAX_PROFILE_URL',      BASE_URL . 'ajax/Profile');
define('IMG_MONITORING',        BASE_URL . 'assets/img/data/monitoring/');

?>