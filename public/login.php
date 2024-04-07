<?php
require(__DIR__.'/../app/Config/Path.php');
require(DIR.'app/Config/Config.php');
require(DIR.'app/Controllers/db_main.php');
require(DIR.'app/Controllers/functions.php');

require(DIR.'app/Controllers/Login.php');
?>
<!DOCTYPE html>
<html lang="ru" class="h-100" data-bs-theme="<?=$_COOKIE['theme']?>">

<?php require(DIR . 'app/Views/HEAD.php');?>

<body class="d-flex flex-column h-100">
    <?php include(DIR . 'app/Views/Header.php');?>

    <main class="container">
        <div class="row justify-content-center">
            <div class="col-lg-3">
                
                <form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
                
                    <div class="my-3" style="font-size:4rem;">
                        <?=SITE_LOGO?>
                    </div>
                    <div class="my-3" style="font-size:4rem;">
                        <?=SITE_NAME_HTML?>
                    </div>
                    <!-- Заголовок -->
                    <h1 class="h3 mb-3 fw-normal">
                        Пожалуйста, войдите
                    </h1>
                    
                    <!-- Login -->
                    <div class="form-floating mb-3">
                        <input type="text" value="<?=$form_data['login']?>" pattern="[a-zA-Z0-9]+" class="form-control" placeholder="Логин" id="login" name="login" aria-label="Login" maxlength="32" required>
                        <label for="login">Логин</label>
                    </div>

                    <!-- Password -->
                    <div class="input-group ">
                        <div class="form-floating">
                            <input type="password" value="<?=$form_data['password']?>" pattern="[a-zA-Z0-9!@#$%^&*()_+-=]+" class="form-control" id="password" name="password" placeholder="Пароль" aria-label="Password" required>
                            <label for="password">Пароль</label>
                        </div>
                        <span class="input-group-text"><i id="toggle-password-icon" class="bi bi-eye"></i></span>
                    </div>
                    <div id="error" class="form-text text-danger"><?=$errMsg?></div>
                    
                    <!-- Галочка запомнить меня -->
                    <div class="my-3 form-check">
                        <input name="remember_me" type="checkbox" class="form-check-input" value="1" id="remeber_me" <?=$form_data['remember_me'] === '1' ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="remeber_me">Запомнить меня</label>
                    </div>

                    <!-- Поле с токеном -->
                    <?=fieldToken()?>
                    
                    <button name="btn-login" type="submit" class="btn btn-primary w-100 mb-5">Войти</button>
                </form>
                
            </div>
        </div>
    </main>

    <?php include(DIR . 'app/Views/ThemeButton.php');?>

    <?php include(DIR . 'app/Views/Footer.php');?>
    <script src="<?=BASE_URL?>assets/js/hide_password.js"></script>
</body>

</html>