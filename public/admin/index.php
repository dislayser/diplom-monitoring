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
                <?php if(empty($_GET['table'])):?>   
                    <!-- Диаграмма с запросами -->
                    <div class="w-100">
                        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-2 mb-3 border-bottom">
                            <h5>Запросы с устройств</h5>
                            <div class="d-flex float-end gap-3">
                                <div class="d-flex gap-2">
                                    <a href="?interval_gasdata=30" class="btn btn-outline-secondary btn-sm"><i class="bi-calendar"></i> за 30 дней</a>
                                    <a href="?interval_gasdata=7" class="btn btn-outline-secondary btn-sm" ><i class="bi-calendar"></i> за 7 дней</a>
                                </div>
                                <div class="vr"></div>
                                <a href="<?=ADMIN_URL . '?table=gas_data'?>" class="btn btn-outline-info btn-sm">Данные о газах<i class="bi-arrow-right-short"></i></a>
                            </div>
                        </div>
                        <canvas id="chart_gasdata" width="5" height="2"></canvas>
                    </div>
                <?php else:?>
                    <div class="d-flex my-5" id="table-titel">
                        <span class="h4">Таблица</span>
                    </div>
                    <?php include(DIR . 'app/Views/TableToolbar.php');?>
                    <?php include(DIR . 'app/Views/Table.php');?>
                <?php endif?>
            <?php endif?>

        </div>
    </main>
    
    <?php include(DIR . 'app/Views/ThemeButton.php');?>

    <?php include(DIR . 'app/Views/Footer.php');?>
    <?php
    if (isset($_GET['interval_gasdata'])){
        $interval_gasdata = (int)$_GET['interval_gasdata'];
    }else{
        $interval_gasdata = 14;
    }
    ?>
    <script>
        let interval_gasdata = <?=$interval_gasdata?>;
        let data_gasdata = <?php
        $data_gasdata = $DB->sql_request_select("
            SELECT DATE(date) AS date, COUNT(*) AS total_gasdata 
            FROM gas_data 
            WHERE date >= CURDATE() - INTERVAL ? DAY 
            GROUP BY DATE(date) 
            ORDER BY DATE(date) ASC",
            array($interval_gasdata))->data;
        
        foreach ($data_gasdata as &$item){
            $item["date"] = format_date($item["date"]);
        }
        echo json_encode($data_gasdata);
        ?>;
    </script>
    <script src="<?=BASE_URL?>assets/js/chart.umd.js"></script>
    <script src="<?=BASE_URL?>assets/js/admin.chart.js"></script>
    <script src="<?=BASE_URL?>assets/js/ajax.func.js"></script>
    <script src="<?=BASE_URL?>assets/js/ajax.gen_token.js"></script>
    <script src="<?=BASE_URL?>assets/js/admin.table.titel.js"></script>
    <script src="<?=BASE_URL?>assets/js/table_links.js"></script>
    <script src="<?=BASE_URL?>assets/js/mark_search.js"></script>
</body>

</html>