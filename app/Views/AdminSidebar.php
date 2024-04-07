<?php
$sidebar_items = array(
    ['users', 'Пользователи', 'person'],
    ['devices', 'Устройства', 'controller'],
);
?>
<!-- Боковая панель для админ панели -->
<div class="offcanvas offcanvas-start w-auto shadow-lg" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="AdminSidebar" aria-labelledby="AdminSidebarLabel">

    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title me-2" id="AdminSidebarLabel">Панель управления</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Закрыть"></button>
    </div>

    <div class="offcanvas-body">
        <ul class="nav nav-pills flex-column mb-auto">
            <?php foreach($sidebar_items as $nav_item):?>
            <li class="nav-item">
                <a href="?table=<?=$nav_item[0]?>" class="nav-link <?=$table_name == $nav_item[0] ? 'active' : 'link-body-emphasis'?>">
                    <i class="bi-<?=$nav_item[2]?> me-2"></i>
                    <?=$nav_item[1]?>
                </a>
            </li>
            <?php endforeach;?>
        </ul>
    </div>

    <!-- Sidebar footer -->
    <div  class="px-3 pb-3">
        <hr>
        <a href="<?=LOGOUT_URL?>" class="btn btn-danger w-100">Выход</a>
    </div>
</div>