<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=SITE_NAME." | ".site_subname();?></title>
    <link href="<?=BASE_URL?>assets/icons/<?=SITE_LOGO_SVG_NAME?>.svg" rel="icon" type="image/svg+xml">
    <!-- Мета -->
    <meta name="description" content="<?=SITE_NAME?> - веб-приложение, для мониторинга газа в местности сотрудниками компании">
    <meta name="keywords" content="Удобный интерфейс, мониторинг, веб-приложение, <?=SITE_NAME?>">
    <!-- Подключение Bootstrap -->
    <?php
    $css = '';
    if(isset($_SESSION['theme']) && !empty($_SESSION['theme'])){
        $css = '/themes/' . $_SESSION['theme'];
    }
    ?>
    <link href="<?=BASE_URL?>assets/css<?=$css?>/bootstrap.min.css" rel="stylesheet" id="main_css">
    <link href="<?=BASE_URL?>assets/css/bootstrap.dropdowns.css" rel="stylesheet">
    <link href="<?=BASE_URL?>assets/icons/bootstrap-icons/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Мои стили -->
    <link href="<?=BASE_URL?>assets/css/style.css" rel="stylesheet">
    <!-- JS библиотеки -->
    <script src="<?=BASE_URL?>assets/js/jquery-3.7.1.min.js"></script>
    <script src="<?=BASE_URL?>assets/js/jquery-ui-1.13.2.min.js"></script>
    <script src="<?=BASE_URL?>assets/js/bootstrap.bundle.min.js"></script>
    <!-- Мои скрипты -->
    <script>
        const BASE_URL = `<?=BASE_URL?>`;
        const SITE_NAME = `<?=SITE_NAME?>`;
        const SITE_NAME_HTML = `<?=SITE_NAME_HTML?>`;
        const SITE_LOGO_SVG_NAME = `<?=SITE_LOGO_SVG_NAME?>`;
        const SITE_LOGO = `<?=SITE_LOGO?>`;
    </script>
    <script src="<?=BASE_URL?>assets/js/toast.js"></script>
    <script src="<?=BASE_URL?>assets/js/main.js"></script>
</head>