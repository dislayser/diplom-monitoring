<?php
require(__DIR__.'/../app/Config/Path.php');
require(DIR.'app/Config/Config.php');
require(DIR.'app/Controllers/db_main.php');
require(DIR.'app/Controllers/functions.php');

//Убираем сохр сессию
$DB->update('users', (int)$_SESSION['id'], ['session_id' => null]);

// Уничтожаем все данные сессии
session_destroy();

$_SESSION = array();

// Опционально: удаляем куки, связанные с сессией (если они есть)
if (isset($_COOKIE[session_name()])) {
    setcookie('session_id', '', time() - 3600, '/');
}

// Перенаправляем пользователя на страницу авторизации
go(LOGIN_URL); 
exit;
?>