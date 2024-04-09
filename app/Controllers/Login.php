<?php

//Авторизация
function auth($userdata, $DB){
    if (!empty($userdata)) {
        // Устанавливаем сессию для авторизованного пользователя
        $_SESSION['auth'] = true;
        $_SESSION['id'] = $userdata['id'];
        $_SESSION['login'] = $userdata['login'];
        $_SESSION['name'] = $userdata['name'];
        $_SESSION['theme'] = $userdata['theme'];
        $_SESSION['rule'] = $DB->select_one('user_rules', ['id' => $userdata['id_rule']])->data['rule'];
        if(isset($_SESSION['attempts'])){
            unset($_SESSION['attempts']);
        }

        $id_user = $userdata['id'];
        $ip_addr = $_SERVER['REMOTE_ADDR'];
        $DB->sql_request("UPDATE users SET last_auth = NOW(), ip = ? WHERE id = ?", array($ip_addr, $id_user));

        // Перенаправление на основную страницу
        go(BASE_URL);
        return true;
    }
    return false;
}

$errMsg = '';
$form_data = [
    'login' => '',
    'password' => '',
    'remember_me' => '',
];

$limit_attempts = 5;    //Ограничение попыток входа
$block_time = 2*60;     //Время блокировки клиента 2*60сек
//Если попытки исчерпаны
if (isset($_SESSION['attempts']) && $_SESSION['attempts']['try'] >= $limit_attempts){
    $left_time = time() - $_SESSION['attempts']['time']; // Оставшееся время
    if ($left_time > $block_time){ 
        unset($_SESSION['attempts']);
    }
    $m = intval(($block_time-$left_time)/60);   //мин
    $s = ($block_time-$left_time)%60;           //сек
    $errMsg = "*Вы заблокированы на " . $m . "м " . $s . "с";
}

//Обнуление параметров авторизации для проверки колличества неудачны попыток авторизации
if (!isset($_SESSION['attempts'])){
    $_SESSION['attempts']['try'] = 0;
    $_SESSION['attempts']['time'] = time();
}

//Автологин если пользовательно нажимал запомнить его
if($_SERVER['REQUEST_METHOD']){
    if (isset($_COOKIE['session_id'])) {
        // Поиск пользователя по идентификатору сессии из куки
        $session_id = $_COOKIE['session_id'];
        $userdata = $DB->select_one('users', ['session_id' => $session_id])->data;
        
        if (!empty($userdata)){
            auth($userdata, $DB);
            exit;
        }
    }
}

//Попытка авторизации
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn-login'])){
    //POST запросы
    if (isset($_SESSION['attempts']) && $_SESSION['attempts']['try'] >= $limit_attempts){
        $form_data = [
            'login' => '',
            'password' => '',
            'remember_me' => '',
        ];
    }else{
        $form_data = [
            'login' => strtolower(trim($_POST['login'])),
            'password' => trim($_POST['password']),
            'remember_me' => (isset($_POST['remember_me']) && $_POST['remember_me'] == '1' )? '1' : '',
        ];

        //Данные для проверки
        $post = [
            'login' => $form_data['login'],
        ];
        
        //Данные о пользователе
        $userdata = $DB->select_one('users', $post)->data;
        
        if (!empty($userdata) && password_verify($form_data['password'], $userdata['password'])) {
            if (checkToken($_POST['token'])){
                //При нажатии галочки запомнить меня
                if ($form_data['remember_me'] == '1') {
                    // Установка куки с идентификатором сессии
                    $session_id = session_id();
                    $ip = $_SERVER['REMOTE_ADDR'];
                    setcookie('session_id', $session_id, time() + 60 * 60 * 24 * 30, '/', null, 0, 1);
                    $DB->update('users', $userdata['id'], ['session_id' => $session_id, 'ip' => $ip]);
                }

                auth($userdata, $DB);
                exit;
            }else{
                $errMsg = '*Ошибка безопасности';
                delToken();
            }
        } else {
            $errMsg = '*Неверный логин или пароль';
            $_SESSION['attempts']['try']++;
            $_SESSION['attempts']['time'] = time();
        }
    }
}


xss($form_data);

?>