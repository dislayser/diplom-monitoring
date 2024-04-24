<?php if(isset($table_name) && isset($table_params) && !empty($table_name) && !empty($table_structure)):?>
<?php
//$DB->limit = 2;
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $DB->cur_page = intval($_GET['page']);
}
$table_rows = $DB->select($table_name, $table_params)->data;
xss($table_rows);

function table_link($id, $type = "edit"){
    if (empty($_GET)){
        $href = $_SERVER['REQUEST_URI'].'?type='.$type.'&id='.(int)$id;
    }else{
        $href = $_SERVER['REQUEST_URI'].'&type='.$type.'&id='.(int)$id;
    }
    return $href;
}
?>

<div class="d-flex gap-3 flex-wrap my-3">

    <?php foreach($table_rows as $row):?>
    <div class="card shadow" style="width: 380px;">
        <div class="card-body">
            <div class="d-flex gap-3">
                <h5 class="text-truncate card-title "><?=$row['name']?></h5>
                <div>
                    <?php
                        $status = $DB->select_one('device_statuses', ['id' => $row['id_status']])->data;
                        xss($status);
                    ?>
                    <span class="badge rounded-pill bg-<?=$status['status']?>"><?=$status['name']?></span>
                </div>
                <span class="ms-auto text-body-secondary text-nowrap"><small><b>ID: <?=$row['id']?></b></small></span>
            </div>
            <h6 class="card-subtitle text-truncate mb-2 text-body-secondary"><?=$row['zone']?></h6>
            <p class="card-text d-flex align-items-center text-wrap gap-2">
                <label class="form-label mb-0">
                    API: 
                </label>
                <input id="api_token" type="text" class="form-control font-monospace  form-control-sm" value="<?=$row['api_token']?>" readonly>
                <button type="button" id="copy" class="btn btn-sm btn-outline-primary" data-parent=".card" data-target="#api_token" data-tooltip="Копировать API"><i class="bi-clipboard"></i></button>
            </p>
            <p class="card-text">
                <?=nl2br($row['description'])?>
            </p>
            
            <div>
                <a href="<?=table_link($row['id'])?>" class="card-link">Редактировать</a>
                <a class="card-link link-danger c-pointer" data-bs-toggle="modal" data-bs-target="#modal_delete" data-row-name="<?=$row['name']?>" data-row-id="<?=$row['id']?>">Удалить</a>
            </div>
        </div>
        <div class="card-footer text-end text-body-secondary py-1 d-flex" style="font-size:0.7rem">
            <span class="me-auto">
                <?=htmlspecialchars($DB->select_one('users', ['id' => $row['id_user']])->data['name'], ENT_QUOTES, 'UTF-8')?>
            </span>
            <?=format_date($row['created'])?>
        </div>
    </div>
    <?php endforeach;?>
    
</div>

<script>
    
    $(document).ready(function(){
        const modal = $('#modal_delete');

        $('a.link-danger').click(function() {
            var body_text = 'Вы действительно хотите удалить';
            var row_id = $(this).data('row-id');
            var row_name = $(this).data('row-name');
            modal.find('.modal-footer input[name="id"]').val(row_id);
            body_text += ' ' +row_name + ' (id: ' + row_id + ')?' 
            modal.find('.modal-body p').text(body_text);
            console.log()
        });
    });    
</script>

<?php include 'Pagination.php';?>

<?php endif;?>