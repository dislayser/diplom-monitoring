<?php
require(__DIR__.'/../../../app/Config/Path.php');
require(DIR.'app/Config/Config.php');
require(DIR.'app/Controllers/db_main.php');
require(DIR.'app/Controllers/functions.php');

include('../API_check.php');

// Для вывода данных в JSON
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    api_check($_POST, $DB);
}
?>