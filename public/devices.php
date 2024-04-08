<?php
require(__DIR__.'/../app/Config/Path.php');
require(DIR.'app/Config/Config.php');
require(DIR.'app/Controllers/db_main.php');
require(DIR.'app/Controllers/functions.php');
require(DIR.'app/Controllers/Auth.php');

require(DIR.'app/Controllers/Devices.php');
?>
<!DOCTYPE html>
<html lang="ru" class="h-100" data-bs-theme="<?=$_COOKIE['theme']?>">

<?php require(DIR . 'app/Views/HEAD.php');?>

<body class="d-flex flex-column h-100">
    <?php include(DIR . 'app/Views/UI.php');?>
    <?php include(DIR . 'app/Views/Header.php');?>
        
    <main class="container">
        <div class="container-fluid ">
            <?php if(isset($_GET['type']) && ($_GET['type'] == 'add' || $_GET['type'] == 'edit')):?>
                <div class="container-md col-xl-7 mt-3">
                    <?php include(DIR . 'app/Views/AdminForms.php');?>
                </div>
            <?php else:?>
                <div class="h3 my-5">
                    Список устройств
                </div>
                <div class="my-3">
                    <?php include(DIR . 'app/Views/TableToolbar.php');?>
                </div>
                <?php include(DIR . 'app/Views/DevicesList.php');?>
            <?php endif;?>
            <?php include(DIR . 'app/Views/Modal.php');?>
        </div>
        
    </main>
    <?php include(DIR . 'app/Views/ToastPlacement.php');?>

    <?php include(DIR . 'app/Views/ThemeButton.php');?>

    <?php include(DIR . 'app/Views/Footer.php');?>
    <script src="<?=BASE_URL?>assets/js/table_links.js"></script>
</body>

</html>