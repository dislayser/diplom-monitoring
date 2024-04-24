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
    
    <?php include(DIR . 'app/Views/ControlPanel.php');?>
    
    <div class="overflow-x-auto overflow-auto position-relative">
        <!-- Кнопка меню -->
        <div class="z-3 position-fixed start-0 ms-3 mt-3">
            <button class="btn btn-primary opacity-75" data-bs-toggle="offcanvas" data-bs-target="#control_panel" aria-controls="offcanvasScrolling"><i class="bi-list"></i></button>
        </div>

        <!-- Визуализация данных -->
        <div id="visual">
            <img src="" class="map" alt="" id="map">
        </div>
    </div>

    <?php include(DIR . 'app/Views/ThemeButton.php');?>

    <script src="<?=BASE_URL?>assets/js/ajax.func.js"></script>
    <script src="<?=BASE_URL?>assets/js/visual.data.js"></script>
</body>

</html>