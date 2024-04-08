<?php
require(__DIR__.'/../app/Config/Path.php');
require(DIR.'app/Config/Config.php');
require(DIR.'app/Controllers/db_main.php');
require(DIR.'app/Controllers/functions.php');
require(DIR.'app/Controllers/Auth.php');
?>
<!DOCTYPE html>
<html lang="ru" class="h-100" data-bs-theme="<?=$_COOKIE['theme']?>">

<?php require(DIR . 'app/Views/HEAD.php');?>

<body class="d-flex flex-column h-100">
    <?php include(DIR . 'app/Views/UI.php');?>
    <?php include(DIR . 'app/Views/Header.php');?>

    <main>
        <div class="container-lg col-lg-7">
            <?php include(DIR . 'app/Views/ProfileForm.php');?>
        </div>
    </main>

    <?php include(DIR . 'app/Views/ThemeButton.php');?>

    <?php include(DIR . 'app/Views/Footer.php');?>
    <script src="<?=BASE_URL?>assets/js/ajax.func.js"></script>
    <script src="<?=BASE_URL?>assets/js/ajax.profile.js"></script>
</body>

</html>