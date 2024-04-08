<?php

?>

<form action="<?=AJAX_PROFILE_URL?>" method="post" class="my-3">
    <div class="h4">Редактирование профиля</div>
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
    </div>
    <?=fieldToken()?>
    <!-- Кнпоки -->
    <hr>
    <div class="d-flex gap-3 flex-row-reverse">
        <button type="submit" class="btn btn-primary" name="<?=$_GET['type']?>">Сохранить</button>
    </div>
</form>