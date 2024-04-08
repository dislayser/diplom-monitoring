<?php
//Проверка авторизации
$auth = false;
if (isset($_SESSION['auth'])){
    $auth = $_SESSION['auth'];
}
if(!$auth){
    go(LOGOUT_URL);
    exit;
}

//ADMIN
if (isset($_SESSION['rule']) && $_SESSION['rule'] != 'admin' && strpos($_SERVER['REQUEST_URI'], '/admin/') !== false){
    //Если пользователь авторизован
    go(BASE_URL);
    exit; // Обязательно завершаем скрипт после перенаправления
}
?>