<?php
$table_structure = $DB->describe($table_name)->data;
?>
<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
    <div class="row g-3">
        <?php foreach($table_structure as $input):?>
            <div class="col-12">
                <label for="<?=$input['Field']?>" class="form-label"><?=ren_col($input['Field'])?></label>
                <input name="<?=$input['Field']?>" class="form-control" id="<?=$input['Field']?>">
            </div>
        <?php endforeach;?>
    </div>
</form>
<??>