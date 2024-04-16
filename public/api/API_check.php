<?php
//Проверка API токена устройства
function api_check($request_data, $DB){
    if(isset($request_data['id'])){
        $device_id  = (int)$request_data['id'];
    }else{
        output(['error_desc' => 'id not found'], 404);
    }
    if(isset($request_data['api_token'])){
        $device_api = $request_data['api_token'];        
    }else{
        output(['error_desc' => 'api_token not found'], 404);
    }

    //data
    $params = [
        'id' => $device_id,
        'id_status' => 2
    ];
    //Получение данных 
    $device = $DB->select_one('devices', $params)->data;

    if(!empty($device)){
        if($device['api_token'] === $request_data['api_token']){
            //return $device;
            output($device);
        }else{
            output(['error_desc' => 'api_token is invalid'], 403);
        }
    }else{
        output(['error_desc' => 'this id does not exist'], 404);
    }
}
?>