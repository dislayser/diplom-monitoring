<?php
// Обязательные параметры для построения таблицы
//$table_name = 'users';
//$table_params = [];
?>

<?php if(isset($table_name) && isset($table_params) && !empty($table_name) && !empty($table_structure)):?>
<?php
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $DB->cur_page = intval($_GET['page']);
}
if (in_array($table_name, $tables_allowed)){
    $table_rows = $DB->select($table_name, $table_params)->data;
}else{
    $table_rows = get_lines("/var/log/apache2/" . $table_name, $DB->limit, $DB->limit * ($DB->cur_page - 1));
    $table_rows = table_structure($table_rows);
}
xss($table_rows);

function table_link($id){
    if (empty($_GET)){
        $href = $_SERVER['REQUEST_URI'].'?type=edit&id='.(int)$id;
    }else{
        $href = $_SERVER['REQUEST_URI'].'&type=edit&id='.(int)$id;
    }
    return $href;
}
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
                if (in_array($table_name, $tables_allowed)){
                    $data_href = table_link($row['id']);
                    echo '<tr data-href="'.$data_href.'" class="c-pointer">';
                    foreach ($table_structure as $col){
                        if($col['Field'] != 'password'){
                            if ($col['Field'] == 'created' || $col['Field'] == 'date') {
                                $val = format_date($row[$col['Field']]);
                            }
                            else{
                                $val = $row[$col['Field']];
                            }
                            echo '<td>'. $val .'</td>';
                        }
                    }
                    echo '</tr>';
                }else{
                    echo '<tr>';
                    foreach ($table_structure as $col){
                            $val = $row[$col['Field']];
                            echo '<td>'. $val .'</td>';
                    }
                    echo '</tr>';
                }
            }  
            ?>
        </tbody>
    </table>
</div>

<?php include 'Pagination.php';?>
<?php endif;?>