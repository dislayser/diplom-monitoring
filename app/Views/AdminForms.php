
<?php
function input($item){
    global $red_star;
    global $form_data;
    global $DB;

    $label = '';
    $input = '';
    $select = '';
    
    $label .= '<label class="form-label"';
    $input .= '<input class="form-control"';
    $select.= '<select class="form-select"';

    
    if (!empty($item['Field'])) {
        $label .= ' for="'.$item['Field'].'">'.ren_col($item['Field']);
        $input .= ' name="'.$item['Field'].'" id="'.$item['Field'].'" placeholder="'.ren_col($item['Field']).'"';

        if (!empty($item['Type'])) {
            switch ($item['Type']){
                case 'varchar(255)': 
                    $input .= ' type="text" maxlength="255"';
                    break;
                case 'varchar(45)':
                    $input .= ' type="text" maxlength="45"';
                    break;
                case 'varchar(32)':
                    $input .= ' type="text" maxlength="32"';
                    break;
                case 'int':
                    $input .= ' type="number" step="1"';
                    break;
                default:
                    break;
            }
        }

        

        if (!empty($form_data)){
            if (isset($form_data['password'])){
                unset($form_data['password']);
            }
            if (isset($form_data[$item['Field']])){
                $input .= ' value="'.$form_data[$item['Field']].'"';
            }
        }

        if (($item['Null'] == 'NO' && $item['Field'] != 'password') || $_GET['type'] == 'add') {
            $label .= $red_star;
            $input .= ' required';
        }
    
    }

    //Для тем
    if($item['Field'] == 'theme'){
        $select.= ' name="'.$item['Field'].'" id="'.$item['Field'].'">';
        $select.= '<option value="">classic</option>';

        $themes_dir = DIR.'public/assets/css/themes';
        $themes_dir_files = scandir($themes_dir);

        $themes = array_filter($themes_dir_files, function($item) use ($themes_dir) {
            return is_dir($themes_dir . '/' . $item) && !in_array($item, ['.', '..']);
        });

        foreach ($themes as $theme){
            $selected = '';
            if (isset($form_data[$item['Field']]) && $theme == $form_data[$item['Field']]) {
                $selected .= 'selected';
            } 
            $select.= '<option value="'.$theme.'" '.$selected.'>'.$theme.'</option>';
        }
    }

    //Список для полей статус
    if ($item['Field'] == 'id_status'){
        $select.= ' name="'.$item['Field'].'" id="'.$item['Field'].'">';
        $statuses = $DB->select('device_statuses')->data;
        foreach ($statuses as $status){
            $selected = '';
            if (isset($form_data['id_status']) && $status['id'] == $form_data['id_status']) {
                $selected .= 'selected';
            } 
            $select.= '<option value="'.$status['id'].'" '.$selected.'>'.$status['name'].'</option>';
        }
    }
    if ($item['Field'] == 'id_rule'){
        $select.= ' name="'.$item['Field'].'" id="'.$item['Field'].'">';
        $rules = $DB->select('user_rules')->data;
        foreach ($rules as $rule){
            $selected = '';
            if (isset($form_data['id_rule']) && $rule['id'] == $form_data['id_rule']) {
                $selected .= 'selected';
            } 
            $select.= '<option value="'.$rule['id'].'" '.$selected.'>'.$rule['rule'].'</option>';
        }
    }
    if ($item['Field'] == 'id_user'){
        $select.= ' name="'.$item['Field'].'" id="'.$item['Field'].'">';
        $users = $DB->select('users')->data;

        if (isset($form_data['id_user'])) {
            $selected_val = $form_data['id_user'];
        }else{
            $selected_val = $_SESSION['id'];
        }
        
        foreach ($users as $user){
            $selected = '';
            if ($user['id'] == $selected_val) {
                $selected .= 'selected';
            }
            $select.= '<option value="'.$user['id'].'" '.$selected.'>'.$user['name']. ' ['.$user['login'].']' .'</option>';
        }
    }

    $label .= '</label>';
    $input .= '>';
    $select.= '</select>';

    if($item['Type'] == 'text'){
        $value = '';
        if(isset($form_data[$item['Field']])){
            $value .= $form_data[$item['Field']];
        }
        $input = '<textarea class="form-control" name="'.$item['Field'].'" id="'.$item['Field'].'" rows="3">'.$value.'</textarea>';
    }
    
    if ($item['Field'] == 'id_status' || $item['Field'] == 'id_rule' || $item['Field'] == 'id_user' || $item['Field'] == 'theme'){
        return $label.$select;
    }

    return $label.$input;
}

//tt($_SERVER);
function get_cancel_link(){
    $link = str_replace('.php', "", $_SERVER['PHP_SELF']);
    if (isset($_GET['table']) && !empty($_GET['table'])) {
        $link = '?table=' .  $_GET['table'];
    }
    return $link;
}
?>
<!-- Форма AdminForms.php -->
<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" class="my-3">
    <div class="h4 d-flex my-3">
        <?php
            if ($_GET['type'] == 'add') {
                echo 'Создать';
            }elseif ($_GET['type'] == 'edit') {
                echo 'Редактировать ID: ' . $_GET['id'];
            }
        ?>
    </div>
    <hr>
    <?=fieldToken()?>
    <div class="row g-3">
        <?php foreach($table_structure as $input):?>
            <?php if($input['Field'] != 'id' && $input['Field'] != 'created' && $input['Field'] != 'last_auth'):?>
            <div class="col-12">
                <?=input($input)?>
            </div>
            <?php endif;?>
        <?php endforeach;?>
    </div>
        <!-- Кнопки -->
        <hr>
        <div class="d-flex gap-3 flex-row-reverse">
            
            <button type="submit" class="btn btn-primary" name="<?=$_GET['type']?>">Сохранить</button>
            <a class="btn btn-secondary" href="<?=get_cancel_link()?>">Отмена</a>
            <?php if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                echo '<button type="submit" class="btn btn-danger" name="delete">Удалить</button>';
            }; ?>
        </div>
</form>