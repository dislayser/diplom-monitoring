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
        $item = trim($item);
    } 
    return $arr;
}

//Получение данных для формы
function get_formData($table_name){
    global $DB;
    global $table_name;
    $arr = array();
    if(isset($_GET['id'])){
        $arr = $DB->select_one($table_name, ['id' => (int)$_GET['id']])->data;
    }
    return $arr;
}

//Сокращенная функция перехода на страницу
function go($url){
    header('Location: '. $url);
    exit;
}

//Для получения парамеров поиска
function get_search(){
    $q = array();
    if (isset($_GET['q']) && isset($_GET['col-search'])) {
        $q[$_GET['col-search']] = "%".$_GET['q']."%";
    }
    return $q;
}

//Переимнование столба
function ren_col($index){
    
    $cols = array(
        'id' => 'ID',
        'name' => 'Имя',
        'created' => 'Создан',
        'status' => 'Статус',
        'id_status' => 'Статус',
        'login' => 'Логин',
        'last_auth' => 'Онлайн',
        'api_token' => 'API Токен',
        'zone' => 'Местоположение',
        'deleted' => 'Удален',
        'password' => 'Пароль',
        'session_id' => 'Сохр. сессия',
        'ip' => 'IP адрес',
        'priority' => 'Приоритет',
        'error' => 'Тест ошибки',
        'id_user' => 'Пользователь',
        'params' => 'Данные',
        'url' => 'URL',
        'rule' => 'Роль',
        'id_rule' => 'Роль',
        'description' => 'Описание',
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

// Возвращаем данные в формате JSON
function output($data, $status = 200){
    http_response_code((int)$status);
    echo json_encode($data);
    exit;
}

//Получить DATETIME
function now(){
    $date = new DateTime();
    return $date->format('Y-m-d H:i:s');
}
?>
