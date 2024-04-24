<?php
$table_structure = $DB->describe($table_name)->data;
$iu_form = [
    'devices' => $DB->describe($table_name)->data
];

tt($table_structure);
?>
<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
    <div class="row g-3">
        <?php foreach($table_structure as $input):?>
        <div class="col-md-6">
            <label class="form-label">123</label>
            <input type="text" class="form-control" name="name" requred>
        </div>
        <?php endforeach;?>
    </div>
</form>