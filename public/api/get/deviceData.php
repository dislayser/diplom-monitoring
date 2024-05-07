<?php
require(__DIR__.'/../../../app/Config/Path.php');
require(DIR.'app/Config/Config.php');
require(DIR.'app/Controllers/db_main.php');
require(DIR.'app/Controllers/functions.php');

//include('../API_check.php');

// Для вывода данных в JSON
header('Content-Type: application/json');

$table_name = 'devices';

// Обработка данных полученных от БПЛА по API
if ($_SERVER['REQUEST_METHOD'] === 'GET'){
    if(isset($_GET['id'])){
        $device_id = (int)$_GET['id'];
    }else{
        output(['error_desc' => 'id not found'], 404);
    }

    $params = [
        'id' => $device_id,
    ];

    $device = $DB->select_one($table_name, $params)->data;

    if (!empty($device)) {
        if(isset($device['api_token'])) unset($device['api_token']);
        
        xss($device);
        output($device);
    }else{
        output([]);
    }
}
?>