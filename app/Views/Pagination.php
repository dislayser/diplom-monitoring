<?php
if(in_array($table_name, $tables_allowed)){
    $totalRows = $DB->count($table_name, $table_params)->data['COUNT(*)'];
}else{
    $totalRows = get_lines_count(ROOT_AMPPS . "apache/logs/" . $table_name);
}
$totalPages = ceil($totalRows / $DB->limit); // Общее количество страниц

// Получаем текущую страницу из параметра GET
/*
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $currentPage = intval($_GET['page']);
} else {
    $currentPage = 1;
}
*/
$currentPage = $DB->cur_page;

// Убедимся, что текущая страница находится в допустимых пределах
if ($currentPage < 1) {
    $currentPage = 1;
} elseif ($currentPage > $totalPages) {
    $currentPage = $totalPages;
}

if ($totalPages > 1) {
    $queryParams = $_GET;
    unset($queryParams['page']); // Удалите параметр 'page' из массива параметров

    $queryStringWithoutPage = http_build_query($queryParams); // Постройте URL-строку без параметра 'page'

    echo '<hr>';

    echo '<nav>';

    echo '<ul class="pagination">';
    if ($currentPage > 1) {
        echo '<li class="page-item"><a class="page-link" href="?'.$queryStringWithoutPage.'&page=1"><i class="bi-chevron-double-left"></i></a></li>';
        echo '<li class="page-item"><a class="page-link" href="?'.$queryStringWithoutPage.'&page='.($currentPage - 1).'"><i class="bi-chevron-left"></i></a></li>';
    }

    for ($i = max(1, $currentPage - 2); $i <= min($totalPages, $currentPage + 2); $i++) {
        if ($i == $currentPage) {
            echo '<li class="page-item active"><span class="page-link">' . $i . '</span></li>';
        } else {
            echo '<li class="page-item"><a class="page-link" href="?'.$queryStringWithoutPage.'&page='.$i.'">' . $i . '</a></li>';
        }
    }

    if ($currentPage < $totalPages) {
        echo '<li class="page-item"><a class="page-link" href="?'.$queryStringWithoutPage.'&page='.($currentPage + 1).'"><i class="bi-chevron-right"></i></a></li>';
        echo '<li class="page-item"><a class="page-link" href="?'.$queryStringWithoutPage.'&page='.$totalPages.'"><i class="bi-chevron-double-right"></i></a></li>';
    }
    echo '</ul>';

    echo '</nav>';
}
?>