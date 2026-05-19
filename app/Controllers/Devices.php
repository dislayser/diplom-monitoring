<?php
$table_name = 'devices';
$table_params = get_search();
$table_structure = $DB->describe($table_name)->data;
$form_data = get_formData($table_name);

//Создание записи
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])){
    unset($_POST['add']);
    if (isset($_POST['token'])){
        $token = $_POST['token'];
        unset($_POST['token']);
    }

    if ($_SESSION['rule'] != 'admin') {
        unset($_POST['id_user']);
    }
    
    arr_clear($_POST);
    
    if (checkToken($token)) {
        if($DB->insert($table_name, $_POST)){
            go(DEVICES_URL);
        }
    }

}
//Изменение записи
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit']) && isset($_GET['id'])){
    
    unset($_POST['edit']);
    if (isset($_POST['token'])){
        $token = $_POST['token'];
        unset($_POST['token']);
    }
    
    if ($_SESSION['rule'] != 'admin') {
        unset($_POST['id_user']);
    }

    arr_clear($_POST);

    if (checkToken($token)) {
        if($DB->update($table_name, (int)$_GET['id'], $_POST)){
            go(DEVICES_URL);
        }
    }
}

//Удаление записи
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete']) && isset($_GET['id'])){
    $token = $_POST['token'];
    if(checkToken($token)) {
        if($DB->delete($table_name, ['id' => (int)$_GET['id']])){
            go(DEVICES_URL);
        }
    }
}elseif($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete']) && isset($_POST['id'])){
    $token = $_POST['token'];
    if(checkToken($token)) {
        if($DB->delete($table_name, ['id' => (int)$_POST['id']])){
            go(DEVICES_URL);
        }
    }
}
if($_SERVER['REQUEST_METHOD'] === 'POST'){

}
xss($form_data)
?>