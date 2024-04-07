<?php
// Возвращает хэшированный токен сессии
function getToken(){
    if (empty($_SESSION['token'])){
        $_SESSION['token'] = uniqid('', true);
    }
    return password_hash($_SESSION['token'], PASSWORD_DEFAULT);
}
// Проверка токена
function checkToken($token){
    return password_verify($_SESSION['token'], $token);
}
//Удаление токена
function delToken(){
    unset($_SESSION['token']);
    return true;
}
// Возвращает скрытое поле с токеном
function fieldToken(){
    return '<input type="hidden" id="token" name="token" value="'.getToken().'">';
}
?>