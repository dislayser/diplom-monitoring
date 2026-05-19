<?php
$sidebar_items = array(
    ['', 'Главная', 'house'],
    ['users', 'Пользователи', 'person'],
    ['devices', 'Устройства', 'controller'],
    ['device_statuses', 'Статусы устройства', 'question'],
    ['user_rules', 'Права пользователей', 'award'],
    ['gas_data', 'Данные о газах', 'clipboard-data'],
    ['gas_types', 'Типы газов', 'hash'],
    ['authorization_attempts', 'Попытки входа', 'key'],

    ['errors', 'Ошибки БД', 'bug'],
    
);

$_GET['table'] = isset($_GET['table']) ? $_GET['table'] : '';
$table_name = $_GET['table'];
?>
<!-- Боковая панель для админ панели -->
<div class="offcanvas offcanvas-start w-auto shadow-lg" data-bs-scroll="true" tabindex="-1" id="AdminSidebar" aria-labelledby="AdminSidebarLabel">

    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title me-2" id="AdminSidebarLabel">Панель управления</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Закрыть"></button>
    </div>

    <div class="offcanvas-body">
        <ul class="nav nav-pills flex-column mb-auto">
            <?php foreach($sidebar_items as $nav_item):?>
                <?php if ($nav_item[0] == 'errors'): ?>
                <li class="nav-item">
                    <a href="?table=<?=$nav_item[0]?>" class="nav-link <?=$table_name == $nav_item[0] ? 'active bg-danger' : 'link-danger'?>">
                        <i class="bi-<?=$nav_item[2]?> me-2"></i>
                        <?=$nav_item[1]?>
                    </a>
                </li>
                <?php else: ?>
                <li class="nav-item">
                    <a href="<?php
                    if (!empty($nav_item[0])){
                        echo '?table='.$nav_item[0]; 
                    }else{
                        echo ADMIN_URL;
                    }
                    ?>"
                    class="nav-link <?=$_GET['table'] == $nav_item[0] ? 'active' : 'link-body-emphasis'?>">
                        <i class="bi-<?=$nav_item[2]?> me-2"></i>
                        <?=$nav_item[1]?>
                    </a>
                </li>
                <?php endif;?>
            <?php endforeach;?>
        </ul>
    </div>

    <!-- Sidebar footer -->
    <div  class="px-3 pb-3">
        <hr>
        <a href="<?=LOGOUT_URL?>" class="btn btn-danger w-100">Выход</a>
    </div>
</div>