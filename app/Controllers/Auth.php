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
?>