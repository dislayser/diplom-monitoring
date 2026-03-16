<?php
require(__DIR__.'/../app/Config/Path.php');
require(DIR.'app/Config/Config.php');
require(DIR.'app/Controllers/functions.php');
?>
<!DOCTYPE html>
<html lang="ru" class="h-100" data-bs-theme="<?=$_COOKIE['theme']?>">

<?php require(DIR . 'app/Views/HEAD.php');?>

<body class="d-flex flex-column h-100">

    <main>
        <div class="container">
            <div class="row my-3">
                <div class="col-7 border-end">
                    <div class="card" id="module_place">
                        
                    </div>
                </div>
                <div class="col-5">
                    <div class="card">
                        <div class="card-header">
                            Основные элементы
                        </div>
                        <div class="card-body">
                            <div class="row g-3" id="items_templates">
                                <label class="form-label">Ярлык на поле</label>
                                <input type="text" class="form-control" placeholder="Текстовое поле">
                                <input type="number" class="form-control" placeholder="Числовое поле">
                                <input type="date" class="form-control" placeholder="Поле сдатой">
                                <input type="file" class="form-control" placeholder="Поле с файлом">
                                <select class="form-select">
                                    <option>...</option>
                                    <option value="" selected>После со списком</option>
                                </select>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </main>

    <?php include(DIR . 'app/Views/ThemeButton.php');?>

    <?php include(DIR . 'app/Views/Footer.php');?>
    <script src="/assets/js/module.custom.js"></script>
</body>

</html>