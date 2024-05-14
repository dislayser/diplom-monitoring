<?php
require(__DIR__.'/../app/Config/Path.php');
require(DIR.'app/Config/Config.php');
?>
<!DOCTYPE html>
<html lang="ru" class="h-100" data-bs-theme="<?=$_COOKIE['theme']?>">

<?php require(DIR . 'app/Views/HEAD.php');?>

<body class="d-flex flex-column h-100">
    <main>
        <div class="modal fade" id="about" tabindex="-1" aria-labelledby="about_lable"  aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="about_lable">О программе</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                    </div>
                    <div class="modal-body">
                        <p>Добро пожаловать в <?=SITE_NAME?>!</p>
                        <p>
                        <?=SITE_NAME_HTML?> - это инновационное веб-приложение, созданное для непрерывного мониторинга и обнаружения утечек газа в промышленных окружениях. Мы стремимся обеспечить безопасность и надежность вашего производства, предоставляя передовые инструменты для оперативного реагирования на потенциальные опасности.
                        </p>
                        <p>Основные функции <?=SITE_NAME?> включают:</p>
                        <ul>
                            <li>Непрерывный мониторинг газов: <?=SITE_NAME?> проводит постоянное отслеживание уровня газов на вашем предприятии с использованием передовых технологий, обеспечивая своевременное обнаружение любых утечек или аномальных концентраций газов.</li>
                            <li>Точная аналитика и отчетность: Наше приложение предоставляет детальные аналитические отчеты о концентрации различных газов в промышленной среде, что помогает вам анализировать и контролировать ситуацию для обеспечения безопасности и эффективности производства.</li>
                            <li>Моментальные уведомления: <?=SITE_NAME?> мгновенно оповещает пользователей о любых обнаруженных утечках или изменениях в концентрации газов с помощью уведомлений на мобильные устройства, обеспечивая оперативное реагирование и минимизацию рисков.</li>
                            <li>Гибкая настройка и интеграция: Мы предлагаем возможность настройки параметров мониторинга в соответствии с уникальными потребностями вашего производства, а также интеграцию с существующими системами безопасности для оптимизации процессов контроля.</li>
                        </ul>
                        Присоединяйтесь к <?=SITE_NAME?> уже сегодня и обеспечьте надежную защиту вашего предприятия от потенциальных опасностей, связанных с утечками газа. Ваша безопасность - наш приоритет!
                        </p>
                        <span class="text-body-secondary">
                        &copy; <?=(date('Y') == CREATED_YEAR) ? CREATED_YEAR : CREATED_YEAR . " - " . date('Y') ; ?> <?=ORG_NAME?>
                        </span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Ок">Ок</button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        $(document).ready(function(){
            $("#about").modal("show");

        });
    </script>
</body>

</html>