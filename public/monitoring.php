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
    <?php include(DIR . 'app/Views/ControlPanel.php');?>
    
    <?php include(DIR . 'app/Views/Header.php');?>
    
    <div class="overflow-x-auto overflow-auto position-relative" style="overflow: hidden!important;">
        <!-- Кнопка меню -->
        <div class="z-3 position-fixed start-0 ms-3 mt-3" >
            <button class="btn btn-primary opacity-75" data-bs-toggle="offcanvas" data-bs-target="#control_panel" aria-controls="offcanvasScrolling"><i class="bi-list"></i></button>
        </div>
        
        <!-- Кнопки зума -->
        <div class="z-3 position-fixed end-0 me-3 mt-3">
            <div class="btn-group opacity-75" role="group" aria-label="Масштабирование">
                <button type="button" id="zoom-in"  class="btn btn-primary"><i class="bi-plus"></i></button>
                <button type="button" id="zoom-out" class="btn btn-primary"><i class="bi-dash"></i></button>
            </div>
        </div>

        <!-- Визуализация данных -->
        <!-- z-n1 position-fixed -->
        <div class="z-1 transition-transform user-select-none" id="visual" style="position: relative; transform: scale(0.6); left: 0; top: 0; transform-origin: 361.92px 229.97px;">
            <img src="" class="map" alt="" id="map">
        </div>
    </div>

    <?php include(DIR . 'app/Views/ThemeButton.php');?>

    <script src="<?=BASE_URL?>assets/js/ajax.func.js"></script>
    <script src="<?=BASE_URL?>assets/js/visual.data.js"></script>
    <script src="<?=BASE_URL?>assets/js/visual.data.new.js"></script>
    <script src="<?=BASE_URL?>assets/js/visual.nav.js"></script>
</body>

</html>