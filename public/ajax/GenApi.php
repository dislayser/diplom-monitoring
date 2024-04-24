<?php
require(__DIR__.'/../../app/Config/Path.php');
require(DIR.'app/Config/Config.php');
require(DIR.'app/Controllers/db_main.php');
require(DIR.'app/Controllers/functions.php');

// Для вывода данных в JSON
header('Content-Type: application/json');

//GET
if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $length = 32;
    if(isset($_GET['length']) && is_numeric($_GET['length']) && (int)$_GET['length'] > 0){
        $length = (int)$_GET['length'];
    }

    //Ограничение на колличество символов
    if ($length > 255) {
        output(['error_desc' => 'length value must not exceed 255 characters']);
    }
    $api_token = ['api_token' => gen_api($length)];
    output($api_token);
}

//Генератор API токена
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