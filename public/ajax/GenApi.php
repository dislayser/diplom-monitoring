<?php
require(__DIR__.'/../../app/Config/Path.php');
require(DIR.'app/Config/Config.php');
require(DIR.'app/Controllers/db_main.php');
require(DIR.'app/Controllers/functions.php');

// Для вывода данных в JSON
header('Content-Type: application/json');

//GET запросы для получения данных о профиле
if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $length = 32;
    if($_GET['length'] && is_numeric($_GET['length'])){
        $length = (int)$_GET['length'];
    }
    $api_token = ['api_token' => gen_api($length)];
    output($api_token);
}

//Генератор
function gen_api($length = 32) {
    // Символы, из которых будет состоять токен
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!"#$%&\'()*+,-./:;<=>?@[\\]^_`{|}~';
    $token = '';

    // Генерируем случайный токен
    for ($i = 0; $i < $length; $i++) {
        $token .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $token;
}
?>