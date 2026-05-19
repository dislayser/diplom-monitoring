<?php
    require(__DIR__.'/../../app/Config/Path.php');
    require(DIR.'app/Config/Config.php');
?>
<!DOCTYPE html>
<html lang="ru" data-bs-theme="<?=$_COOKIE['theme']?>">
<?php require(DIR . 'app/Views/HEAD.php');?>

<body>
    <div class="container">
        <div class="d-flex align-items-center justify-content-center vh-100">
            <div class="text-center">
                <h1 class="display-1 fw-bold">403</h1>
                <p class="fs-3"><span class="text-danger">Opps!</span> Page not found.</p>
                <p class="lead">
                    У вас недостаточно прав на этот ресурс :)
                </p>
                <a href="/" class="btn btn-primary">На главную</a>
            </div>

            <?php //include('./main.php')?>

        </div>
    </div>
</body>
</html>