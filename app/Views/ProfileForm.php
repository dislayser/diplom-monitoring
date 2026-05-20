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
            <label class="form-label" for="ip">IP адресс</label>
            <input class="form-control" name="ip" id="ip" type="text" placeholder="IP адресс" disabled>
        </div>
        <div class="col-12 col-md-6">
            <label class="form-label" for="rule">Роль пользователя</label>
            <input class="form-control" name="rule" id="rule" type="text" placeholder="Роль пользователя" disabled>
        </div>

        <div class="col-12">
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

        <div class="d-flex text-body-secondary">
            <small class="ms-auto"><b>ID пользователя: <span id="id"><?=$_SESSION['id']?></span></b></small>
        </div>
    </div>
    <?=fieldToken()?>
    <!-- Кнпоки -->
    <hr>
    <div class="d-flex gap-3 flex-row-reverse">
        <button type="submit" class="btn btn-primary" name="save">Сохранить</button>
        <button type="button" class="btn btn-link text-decoration-none" data-bs-toggle="modal" data-bs-target="#modal_password">Изменить пароль</button>
    </div>

    <!-- Модалка на изменение пароля -->
    <div class="modal fade" id="modal_password" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modal-label">Изменить пароль</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label" for="password_old">Старый пароль</label>
                            <div class="input-group">
                                <input class="form-control" pattern="[a-zA-Z0-9!@#$%^&*()_+-=]+" name="password_old" id="password_old" type="password" placeholder="Введите старый пароль">
                                <span class="input-group-text"><i id="toggle-password-icon" data-target="#password_old" class="bi bi-eye toggle-password-icon"></i></span>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="password_new">Новый пароль</label>
                            <div class="input-group">
                                <input class="form-control" pattern="[a-zA-Z0-9!@#$%^&*()_+-=]+" name="password_new" id="password_new" type="password" placeholder="Введите новый пароль">
                                <span class="input-group-text"><i id="toggle-password-icon" data-target="#password_new" class="bi bi-eye toggle-password-icon"></i></span>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="password_repeat">Новый пароль</label>
                            <div class="input-group">
                                <input class="form-control" pattern="[a-zA-Z0-9!@#$%^&*()_+-=]+" name="password_repeat" id="password_repeat" type="password" placeholder="Повторите новый пароль">
                                <span class="input-group-text"><i id="toggle-password-icon" data-target="#password_repeat" class="bi bi-eye toggle-password-icon"></i></span>
                            </div>
                        </div>
                        <span class="invalid-feedback" id="error"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">Отмена</button>
                    <button type="submit" class="btn btn-primary" name="change_password">Изменить</button>
                </div>
            </div>
        </div>
    </div>
    <script src="<?=BASE_URL?>assets/js/password.repeat.js"></script>
    
</form>