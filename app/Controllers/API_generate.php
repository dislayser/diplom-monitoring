<?php

function gen_api($length = 32) {
    // Символы, из которых будет состоять токен
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $token = '';

    // Генерируем случайный токен
    for ($i = 0; $i < $length; $i++) {
        $token .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $token;
}

// Генерируем токен длиной 32 символа
$api_token = gen_api();

echo $api_token;