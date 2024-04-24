<?php
//Базовые настройки
date_default_timezone_set('Asia/Yekaterinburg'); // Установка времени по ЕКБ
//Старт сессии
ini_set('session.cookie_httponly', 1);
session_start();

//Брендинг
define('SITE_NAME', 'GasTrack');
define('SITE_NAME_HTML', 'Gas<b><span class="text-warning">Track</span></b>');
define('SITE_LOGO_SVG_NAME', 'display');
define('SITE_LOGO', '<i class="bi-'.SITE_LOGO_SVG_NAME.'"></i>');

//Ссылки в навигационной панели
$main_links = array(
    '/monitoring.php' => ['Мониторинг', MONITORING_URL],
    '/devices.php' => ['Устройства', DEVICES_URL],
    '/profile.php' => ['Профиль', PROFILE_URL],
    '/admin/index.php' => ['Администрирование', ADMIN_URL],
    '/login.php' => ['Вход', LOGIN_URL],
    '/logout.php' => ['Выход', LOGOUT_URL],
);

//Вызвращает наимеование страницы
function site_subname(){
    
    global $main_links;
    if (isset($main_links[$_SERVER['PHP_SELF']])){
        return $main_links[$_SERVER['PHP_SELF']][0];
    }

    switch ($_SERVER['PHP_SELF']){
        //Общие страницы
        case "/index.php":
            return 'Главная';
            break;
        case "/about.php":
            return 'О программе';
            break;
        case "/test.php":
            return 'Тестовая страница';
            break;
        
        //Страницы с ошибкой
        case "/error/404.php":
            return '404';
            break;
        case "/error/403.php":
            return '403';
            break;

        default:
            return 'Безымянный';
            break;
    }
}

//Данные для футера сайта
define('CREATED_YEAR', 2024);
define('ORG_NAME', 'ООО "Полиграфия"');

//Разрешенные таблицы
$tables_allowed = [
    'users',
    'devices',
    'device_statuses',
    'user_rules',
    'gas_data',
    'gas_types',
    'errors',
    'authorization_attempts',
];
//Разрешенные файлы
$files_allowed = [
    'gastrack.access.log',
    'gastrack.error.log',
];
?>
