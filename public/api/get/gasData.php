<?php
require(__DIR__.'/../../../app/Config/Path.php');
require(DIR.'app/Config/Config.php');
require(DIR.'app/Controllers/db_main.php');
require(DIR.'app/Controllers/functions.php');

//include('../API_check.php');

// Для вывода данных в JSON
header('Content-Type: application/json');

$table_name = 'gas_data';

// Обработка данных полученных от БПЛА по API
if ($_SERVER['REQUEST_METHOD'] === 'GET'){
    if(isset($_GET['id'])){
        $device_id = (int)$_GET['id'];
    }else{
        output(['error_desc' => 'id not found'], 404);
    }

    $params = [
        'id_device' => $device_id,
    ];

    $gas = $DB->select_one($table_name, $params)->data;

    if (!empty($gas)) {
        //Перевод json в обычный массив
        $gas['data'] = json_decode($gas['data']);
        
        xss($gas);
        output($gas);
    }else{
        output([]);
    }
}
?>