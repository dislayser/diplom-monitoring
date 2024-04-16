<?php
require(__DIR__.'/../../app/Config/Path.php');
require(DIR.'app/Config/Config.php');
require(DIR.'app/Controllers/db_main.php');
require(DIR.'app/Controllers/functions.php');
require(DIR.'app/Controllers/Auth.php');

require(DIR.'app/Controllers/Admin.php');
?>
<!DOCTYPE html>
<html lang="ru" class="h-100" data-bs-theme="<?=$_COOKIE['theme']?>">

<?php require(DIR . 'app/Views/HEAD.php');?>

<body class="d-flex flex-column h-100">
    <?php include(DIR . 'app/Views/UI.php');?>
    <?php include(DIR . 'app/Views/Header.php');?>

    <main class="d-flex flex-nowrap">
        <?php include(DIR . 'app/Views/AdminSidebar.php');?>

        <div class="container">
            
            <?php include(DIR . 'app/Views/AdminToolbar.php');?>

            <?php if(isset($_GET['type']) && ($_GET['type'] == 'add' || ($_GET['type'] == 'edit') && isset($_GET['id']))):?>  
                <div class="container-md col-xl-7 mt-3">
                    <?php include(DIR . 'app/Views/AdminForms.php');?>
                </div>
            <?php elseif(!isset($_GET['type'])):?>
                <div class="d-flex my-5" id="table-titel">
                    <span class="h4">Таблица</span>
                </div>
                <?php include(DIR . 'app/Views/TableToolbar.php');?>
                <?php include(DIR . 'app/Views/Table.php');?>
            <?php endif?>

        </div>
    </main>
    <?php include(DIR . 'app/Views/ThemeButton.php');?>

    <?php include(DIR . 'app/Views/Footer.php');?>
    
    <script src="<?=BASE_URL?>assets/js/ajax.func.js"></script>
    <script src="<?=BASE_URL?>assets/js/ajax.gen_token.js"></script>
    <script src="<?=BASE_URL?>assets/js/admin-table-titel.js"></script>
    <script src="<?=BASE_URL?>assets/js/table_links.js"></script>
    <script src="<?=BASE_URL?>assets/js/mark_search.js"></script>
</body>

</html>