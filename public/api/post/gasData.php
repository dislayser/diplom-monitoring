<?php
require(__DIR__.'/../../../app/Config/Path.php');
require(DIR.'app/Config/Config.php');
require(DIR.'app/Controllers/db_main.php');
require(DIR.'app/Controllers/functions.php');

include('../API_check.php');

// Для вывода данных в JSON
header('Content-Type: application/json');

$table_name = 'gas_data';

// Обработка данных полученных от БПЛА по API
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    //Проверка API токена
    $device_data = api_check($_POST, $DB);

    if(!empty($device_data)){
        //Преобразование данных о газе в json - в случае если данные не пришли в формате json
        if (is_array($_POST['data'])) {
            $_POST['data'] = json_encode($_POST['data']);
        }
        
        //gas_data в json
        $params = [
            'date' => now(),
            'data' => $_POST['data'],
            'id_device' => $device_data['id'],
        ];

        $last_id = $DB->insert($table_name, $params)->data;
        output(['id' => $last_id]);
    }
}
?>