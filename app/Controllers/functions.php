<?php
//Для работы с токенами
include 'Token.php';

//Функция для тестрования массивов и тд
function tt($value = []){
    echo '<pre>';
    print_r($value);
    echo '<pre>';
}

//Преобразует строку/массивы для вставки как текст на HTML страницу, для предотвращения xss аттак
function xss(&$item, $params = ENT_QUOTES, $charset = 'UTF-8') {
    if (is_array($item)) {
        foreach ($item as &$val) {
            xss($val);
        } 
    } else {
        if (is_string($item)) {
            $item = htmlspecialchars($item, $params, $charset);
        }
    }
}

//Приравнивает NULL если значение пустое
function arr_clear(&$arr){
    foreach ($arr as &$item){
        if ($item === ''){
            $item = null;
        }
    } 
    return $arr;
}

//Сокращенная функция перехода на страницу
function go($url){
    header('Location: '. $url);
}

//Переимнование столба
function ren_col($index){
    
    $cols = array(
        'id' => 'ID',
        'name' => 'Имя',
        'created' => 'Создан',
        'status' => 'Статус',
        'login' => 'Логин',
        'api_token' => 'API Токен',
        'zone' => 'Местоположение',
        'deleted' => 'Удален',
        'password' => 'Пароль',
        'session_id' => 'Сохр. сессия',
        'ip' => 'IP адрес',
    );

    if (isset($cols[$index])){
        $index = $cols[$index];
    }

    xss($index);
    return $index;
}


//Преобразовывает дату
function format_date($val){
    if (empty($val)){
        return '';
    }
    $date = new DateTime($val);

    // Форматируем дату в нужный формат
    $formatted = $date->format('d.m.Y');
    
    // Если входная строка содержит время, добавляем его к форматированной дате
    if (strpos($val, ' ') !== false) {
        $formatted .= ' ' . $date->format('H:i');
    }

    return $formatted;
}
?>
