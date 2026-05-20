<!-- Кастомное контекстное меню -->
<?php
    $popup_items = [
        ["Открыть", "popup-open","bi-eye"],
        ["Редактировать", "popup-edit","bi-pencil"],
        ["Удалить", "popup-delete","bi-trash"],
    ];
    xss($popup_items);
?>
<div id="popup" class="dropdown-menu position-absolute mx-0 shadow w-220px" style="display: none;">
    <?php foreach($popup_items as $item):?>
        <?php if ($item[0] == "Удалить"):?>
        <hr class="dropdown-divider">
        <?php endif;?>
        <a class="dropdown-item <?=$item[0] == "Удалить" ? "dropdown-item-danger" : "";?> c-pointer" id="<?=$item[1]?>">
            <div class=" d-flex gap-2 align-items-center">
                <i class="<?=$item[2]?>" width="16" height="16"></i>
                <?=$item[0]?>
            </div>
        </a>
    <?php endforeach;?>
</div>
<script src="<?=BASE_URL?>assets/js/table.popup.js"></script>