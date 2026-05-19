<?php
//Проверка API токена устройства
function api_check($request_data, $DB){

    //Проверка ID
    if(isset($request_data['id'])){
        $device_id  = (int)$request_data['id'];
    }else{
        output(['error_desc' => 'id not found'], 404);
    }

    //Проверка API токена
    if(isset($request_data['api_token'])){
        $device_api = $request_data['api_token'];        
    }else{
        output(['error_desc' => 'api_token not found'], 404);
    }

    //Статус устройства
    $success_id = $DB->select_one('device_statuses', ['status' => 'success'])->data['id'];

    //Параметры по которым находится утройство 
    $params = [
        'id' => $device_id,
        'id_status' => $success_id,
    ];

    //Получение данных 
    $device = $DB->select_one('devices', $params)->data;

    if(!empty($device)){
        if($device['api_token'] === $request_data['api_token']){
            return $device;
        }else{
            output(['error_desc' => 'api_token is invalid'], 403);
        }
    }else{
        output(['error_desc' => 'device does not exist or is unavailable'], 404);
    }

    return null;
}
?>