<?php
require(__DIR__.'/../../../app/Config/Path.php');
require(DIR.'app/Config/Config.php');
require(DIR.'app/Controllers/db_main.php');
require(DIR.'app/Controllers/functions.php');

include('../API_check.php');

// Для вывода данных в JSON
header('Content-Type: application/json');

$table_name = 'gas_data';

//output($_FILES, 404);
// Обработка данных полученных от БПЛА по API
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    //Проверка API токена
    $device_data = api_check($_POST, $DB);

    if(!empty($device_data)){
        if (isset($_POST['data'])){   
            //output($_POST['data']);
            //Преобразование данных о газе в json - в случае если данные не пришли в формате json
            if (is_array($_POST['data'])) {
                $_POST['data'] = json_encode($_POST['data']);
            }

            //Файл
            $file = '1.png';
            if (isset($_POST['map_file']) && !empty($_POST['map_file'])){
                $file = $_POST['map_file'];
            } 
            
            //Обработка файла
            if (isset($_FILES['map_file']) && !empty($_FILES['map_file'])){                            
                $allowedTypes = ['image/jpeg', 'image/png'];
                $maxSize = 5 * 1024 * 1024; // 5 MB
                $uploadDir = DIR . 'public/assets/img/data/monitoring/';

                $file = $_FILES['map_file'];

                $valid_file = file_check($file, $allowedTypes, $maxSize);
                if ($valid_file === true){
                    $saveResult = file_save($file, $uploadDir);
                    if (is_string($saveResult)) {
                        $file = $saveResult;
                    } else {
                        output(['error_desc' => $saveResult], 404);
                    }
                }else{
                    output(['error_desc' => $valid_file], 404);
                }
            }
            
            //gas_data в json
            $params = [
                'date' => now(),
                'data' => $_POST['data'],
                'map_file' => $file,
                'id_device' => $device_data['id'],
                'ip' => $_SERVER['REMOTE_ADDR'],
            ];

            if (check_data($params['data'])){
                $inserted_id = $DB->insert($table_name, $params)->data;
                output(['created_id' => $inserted_id]);
            }   
        }else{
            output(['error_desc' => 'data not found'], 404);
        }
    }
}

//Проверка данных
function check_data($data){
    $gas_types = ['PM2.5', 'PM10', 'SO2', 'CO', 'NO2', 'O2', 'O3', 'VOCs', 'LEL/CH4', 'CO2', 'H2S', 'NH3', 'HCl', 'H2', 'Cl2', 'PH3'];
    $gas_data = json_decode($data);
    if ($gas_data !== null) {
        return true;
    }else{
        output(['error_desc' => 'data is not json'], 404);
    }
}
?>