<?php
require(__DIR__.'/../../../app/Config/Path.php');
require(DIR.'app/Config/Config.php');
require(DIR.'app/Controllers/db_main.php');
require(DIR.'app/Controllers/functions.php');

//include('../API_check.php');

// Для вывода данных в JSON
header('Content-Type: application/json');

$DB->limit = 100;
$table_name = 'gas_types';

// Обработка данных полученных от БПЛА по API
if ($_SERVER['REQUEST_METHOD'] === 'GET'){
    if(isset($_GET['name'])){
        $params = [
            'name' => $_GET['name'],
        ];
    }else{
        $params = [];
    }

    $types = $DB->select($table_name, $params)->data;

    if (!empty($types)) {
        //Перевод json в обычный массив
        xss($types);
        output($types);
    }else{
        output([]);
    }
}
?>