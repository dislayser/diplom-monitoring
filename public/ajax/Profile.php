<?php
require(__DIR__.'/../../app/Config/Path.php');
require(DIR.'app/Config/Config.php');
require(DIR.'app/Controllers/db_main.php');
require(DIR.'app/Controllers/functions.php');
require(DIR.'app/Controllers/Auth.php');

header('Content-Type: application/json');
//Сохранение профиля
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if (isset($_POST['id'])){
        $id = $_POST['id'];
        unset($_POST['id']);
    }
    if (isset($_POST['token'])){
        $token = $_POST['token'];
        unset($_POST['token']);
    }

    arr_clear($_POST);

    if(checkToken($token)) {
        if ($DB->update('users', (int)$id, $_POST)){
            $_SESSION['name'] = $_POST['name'];
            $_SESSION['login'] = $_POST['login'];
            $_SESSION['theme'] = $_POST['theme'];
            output(['status' => 200]);
        }else{
            output(['status' => 404]);
        }
    }
}

//GET запросы для получения данных о профиле
if($_SERVER['REQUEST_METHOD'] === 'GET'){
    if (isset($_SESSION['id'])){
        $profile_data = $DB->select_one('users', ['id' => (int)$_SESSION['id']])->data;
        xss($profile_data);
        output($profile_data);
    }
}

// Возвращаем данные в формате JSON
function output($data){
    echo json_encode($data);
    exit;
}
?>