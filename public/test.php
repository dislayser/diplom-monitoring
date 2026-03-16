<?php
require(__DIR__.'/../app/Config/Path.php');
require(DIR.'app/Config/Config.php');
require(DIR.'app/Controllers/db_main.php');
require(DIR.'app/Controllers/functions.php');
require(DIR.'app/Controllers/Auth.php');
?>

<?php
// Пример использования функций
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $allowedTypes = ['image/jpeg', 'image/png'];
    $maxSize = 5 * 1024 * 1024; // 5 MB
    $uploadDir = DIR . 'public/assets/img/data/monitoring/';
    
    $file = $_FILES['map_file'];
    //tt($file);
        
    // Проверка файла
    $validationResult = file_check($file, $allowedTypes, $maxSize);
    if ($validationResult === true) {
        // Сохранение файла
        $saveResult = file_save($file, $uploadDir);
        if (is_string($saveResult)) {
            echo "Файл успешно загружен: " . htmlspecialchars($saveResult);
        } else {
            echo "Ошибка: " . htmlspecialchars($saveResult);
        }
    } else {
        echo "Ошибка: " . htmlspecialchars($validationResult);
    }
}
?>

<!DOCTYPE html>
<html lang="ru" class="h-100" data-bs-theme="<?=$_COOKIE['theme']?>">

<?php require(DIR . 'app/Views/HEAD.php');?>

<body class="d-flex flex-column h-100">
    <?php include(DIR . 'app/Views/Header.php');?>

    <main class="container my-5"> 
        <form action="<?=$_SERVER["PHP_SELF"]?>" method="post" enctype="multipart/form-data">
            <input class="form-control my-3" type="file" value="" name="map_file" accept="image/jpeg, image/png" required>
            <button type="submit" class="btn btn-primary my-3">Submit</button>
        </form>
    </main>

    <?php include(DIR . 'app/Views/ThemeButton.php');?>

    <?php include(DIR . 'app/Views/Footer.php');?>
</body>

</html>