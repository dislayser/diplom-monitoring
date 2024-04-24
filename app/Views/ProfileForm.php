<?php

?>

<div class="h4 my-5">Редактирование профиля</div>
<form action="<?=AJAX_PROFILE_URL?>" method="post" class="my-3">
    <hr>
    <input type="hidden" name="id" id="id" value="<?=$_SESSION['id']?>">
    <div class="row g-3">
        <div class="col-12 col-md-6">
            <label class="form-label" for="name">Имя</label>
            <input class="form-control" name="name" id="name" type="text" placeholder="Введите ваше имя">
        </div>
        <div class="col-12 col-md-6">
            <label class="form-label" for="login">Логин</label>
            <input class="form-control" name="login" id="login" type="text" placeholder="Введите логин">
        </div>
        <div class="col-12 col-md-6">
            <?php
                $themes_dir = DIR.'public/assets/css/themes';
                $themes_dir_files = scandir($themes_dir);

                $themes = array_filter($themes_dir_files, function($item) use ($themes_dir) {
                    return is_dir($themes_dir . '/' . $item) && !in_array($item, ['.', '..']);
                });
            ?>
            <label class="form-label" for="theme">Тема</label>
            <select class="form-select" name="theme" id="theme">
                <?php
                    echo '<option value="">classic</option>';
                foreach($themes as $theme){
                    echo '<option value="'.$theme.'">'.$theme.'</option>';
                }
                ?>
            </select>
        </div>
    </div>
    <?=fieldToken()?>
    <!-- Кнпоки -->
    <hr>
    <div class="d-flex gap-3 flex-row-reverse">
        <button type="submit" class="btn btn-primary" name="save">Сохранить</button>
    </div>
</form>