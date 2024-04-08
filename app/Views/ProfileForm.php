<?php

?>

<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" class="my-3">
    <div class="h4">Редактирование профиля</div>
    <hr>

    <div class="row g-3">
        <div class="col-12 col-md-6">
            <label for=""></label>
        </div>
        <div class="col-12 col-md-6">

        </div>
        <div class="col-12 col-md-6">

        </div>
        <div class="col-12 col-md-6">

        </div>
    </div>
    <?=fieldToken()?>
    <!-- Кнпоки -->
    <hr>
    <div class="d-flex gap-3 flex-row-reverse">
        <button type="submit" class="btn btn-primary" name="<?=$_GET['type']?>">Сохранить</button>
    </div>
</form>