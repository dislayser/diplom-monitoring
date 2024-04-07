<?php
// Обязательные параметры для построения таблицы
//$table_name = 'users';
//$table_params = [];
?>

<?php if(isset($table_name) && isset($table_params) && !empty($table_name)):?>
<?php
$table_structure = $DB->describe($table_name)->data;
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $DB->cur_page = intval($_GET['page']);
}
$table_rows = $DB->select($table_name, $table_params)->data;
xss($table_rows);
?>
<!-- Таблицa <?=$table_name?> -->
<div class="table-responsive my-3">
    <table class="table table-hover text-nowrap">
        <thead>
            <tr>
                <?php
                foreach ($table_structure as $col){
                    if($col['Field'] != 'password'){
                        echo '<th scope="col">'. ren_col($col['Field']) .'</th>';
                    }
                }
                ?>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <?php
            foreach ($table_rows as $row){
                echo '<tr class="c-pointer">';
                foreach ($table_structure as $col){
                    if($col['Field'] != 'password'){
                        if ($col['Field'] == 'created') {
                            $val = format_date($row[$col['Field']]);
                        }
                        else{
                            $val = $row[$col['Field']];
                        }
                        echo '<td>'. $val .'</td>';
                    }
                }
                echo '</tr>';
            }  
            ?>
        </tbody>
    </table>
</div>

<?php include 'Pagination.php';?>
<?php endif;?>