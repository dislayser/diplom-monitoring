<?php
require(DIR.'app/Models/Database.php');
//Файл с авторизацией к базе данных
$db_auth = require(DIR.'secret/db.php');

//Обект для работы с базой данных
$DB = new Database($db_auth['db']['main'], $db_auth['user'], $db_auth['pass']);
$DB->connect(); //Соединение
?>