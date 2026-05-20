<?php

if (isset($_GET['table']) && !empty($_GET['table'])){
    $table_name = $_GET['table'];
    $table_params = get_search();
    if (in_array($table_name, $tables_allowed)){
        $table_structure = $DB->describe($table_name)->data;
        $table_params = get_search();
        $form_data = get_formData($table_name);
    }elseif(in_array($table_name, $files_allowed)){
        $table_structure = [['Field' => 'data']];
    }
}


//Создание записи
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])){
    unset($_POST['add']);
    if (isset($_POST['token'])){
        $token = $_POST['token'];
        unset($_POST['token']);
    }

    if($table_name == 'users' && isset($_POST['password'])){
        
        $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
    }

    arr_clear($_POST);
    
    if(checkToken($token)) {
        if($DB->insert($table_name, $_POST)){
            go(ADMIN_URL . "?table=$table_name");
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
    if($table_name == 'users' && isset($_POST['password'])){
        if(!empty($_POST['password'])){
            $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);            
        }else{
            unset($_POST['password']);
        }
    }
    arr_clear($_POST);
    if(checkToken($token)) {
        if($DB->update($table_name, (int)$_GET['id'], $_POST)){
            go(ADMIN_URL . "?table=$table_name");
        }
    }
}

//Удаление записи
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete']) && isset($_GET['id'])){
    $token = $_POST['token'];
    if(checkToken($token)) {
        if($DB->delete($table_name, ['id' => (int)$_GET['id']])){
            go(ADMIN_URL . "?table=$table_name");
        }
    }
}

xss($form_data);
?>