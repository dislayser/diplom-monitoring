<?php
require(__DIR__.'/../../app/Config/Path.php');
require(DIR.'app/Config/Config.php');
require(DIR.'app/Controllers/db_main.php');
require(DIR.'app/Controllers/functions.php');
require(DIR.'app/Controllers/Auth.php');

// Для вывода данных в JSON
header('Content-Type: application/json');
//Сохранение профиля
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if (isset($_POST['id'])){
        if ($_SESSION['rule'] != 'admin') {
            $id = $_SESSION['id'];
        }else{
            $id = $_POST['id'];
        }
        unset($_POST['id']);
    }else{
        output(['status' => 404]);
    }
    if (isset($_POST['token'])){
        $token = $_POST['token'];
        unset($_POST['token']);
    }

    arr_clear($_POST);

    if(checkToken($token)) {
        $profile_data = $DB->select_one('users', ['id' => $id])->data;
        //Работа с паролем:
        $password_old = '';
        $password_new = '';
        $password_repeat = '';
        if (isset($_POST['password_old'])){
            $password_old = trim($_POST['password_old']);
            unset($_POST['password_old']);
        }
        if (isset($_POST['password_new'])){
            $password_new = trim($_POST['password_new']);
            unset($_POST['password_new']);
        }
        if (isset($_POST['password_repeat'])){
            $password_repeat = trim($_POST['password_repeat']);
            unset($_POST['password_repeat']);
        }
        if (password_verify($password_old, $profile_data['password'])){
            if (!empty($password_new) && !empty($password_repeat) && $password_new === $password_repeat){
                $_POST['password'] = password_hash($password_new, PASSWORD_DEFAULT);
            }
        }

        if ($DB->update('users', (int)$id, $_POST)){
            $_SESSION['name'] = $_POST['name'];
            $_SESSION['login'] = $_POST['login'];
            $_SESSION['theme'] = $_POST['theme'];
            output(['status' => 200]);
        }else{
            output(['status' => 404]);
        }
    }else{
        output(['status' => 403]);
    }
}

//GET запросы для получения данных о профиле
if($_SERVER['REQUEST_METHOD'] === 'GET'){
    if (isset($_SESSION['id'])){
        $profile_data = $DB->select_one('users', ['id' => (int)$_SESSION['id']])->data;
        $profile_data['rule'] = $DB->select_one('user_rules', ['id' => (int)$profile_data['id_rule']])->data['rule'];
        xss($profile_data);
        output($profile_data);
    }else{
        output(['status' => 404, 'error_desc' => 'session.id not found']);
    }
}

?>