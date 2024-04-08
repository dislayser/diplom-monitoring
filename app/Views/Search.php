<?php

?>
<form action="<?=$_SERVER['REQUEST_URI']?>" method="get" class="d-flex gap-2">
    <select name="col-search" id="col-search" class="form-select">
        <?php
        foreach ($table_structure as $item) {
            if ($item['Field'] != 'password') {
                $is_selected = '';
                if (isset($_GET['col-search']) && $item['Field'] == $_GET['col-search']) {
                    $is_selected = 'selected';
                }
                echo '<option value="'.$item['Field'].'" '.$is_selected.'>'.ren_col($item['Field']).'</option>'; 
            }            
        }
        ?>
    </select>
    <?php
        if (isset($_GET['table']) && !empty($_GET['table'])){
            echo ui_input_hidden('table', $_GET['table']);
        }
        echo ui_input('q', null, 'Поиск...',  null,  null, isset($_GET['q']) ? htmlspecialchars($_GET['q']) : null, 'search');
        echo ui_submit('btn-search', '<i class="bi-search"></i>', 'btn btn-outline-success');
    ?>
</form>
