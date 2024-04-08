$(document).ready(function(){
    //GET запрос
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);

    // Получаем значение определенного параметра по его имени
    var search_word = null;
    if (urlParams.get('q') != null){
        search_word = urlParams.get('q').trim();
    }

    var num_col = null;
    if (get_col_name() != null){
        num_col = get_col(get_col_name().trim());
    }

    //Находим номер столбца
    function get_col(col_name, thead = $('table thead tr')) {
        thead = thead.find('th');
        for (var i = 0; i < thead.length; i++) {
            if ($(thead[i]).text().includes(col_name)) { // Внесены изменения здесь
                return parseInt(i);
            }
        }
        return null;
    }

    //Находим выборанный столбец
    function get_col_name(select = $('[name="col-search"] option')){
        for (var i = 0; i < select.length; i++) {
            if (select[i].selected){
                return select[i].innerText;
            }
        }
        return null;
    }

    //Маркировка текста
    function mark_word(text = null, col = null, tbody = $('table tbody tr')){
        if (text === null || text === ''){
            return false;
        }

        for (var i = 0; i < tbody.length; i++) {
            var cell = null;
            if (col !== null){
                cell = tbody[i].cells[col];
            } else{
                cell = tbody[i];
            }

            var td_content = null;
            if ($(cell).find('span').find('span').length > 0){
                td_content = $(cell).find('span').find('span'); // Находим текст только внутри элемента с классом .text-truncate
            } else if ($(cell).find('span').length > 0){
                td_content = $(cell).find('span'); // Находим текст только внутри элемента с классом .text-truncate
            } else if ($(cell).find('a').length > 0){
                td_content = $(cell).find('a'); // Находим текст только внутри элемента с классом .text-truncate
            } else {
                td_content = $(cell); // Находим текст только внутри элемента с классом .text-truncate
            }

            var cellContents = td_content[0].innerHTML;
            
            var escapedText = text.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
            var searchRegex = new RegExp('(' + escapedText + ')', 'gi');

            if (cellContents.toLowerCase().includes(text.toLowerCase())) {
                var markedText = cellContents.replace(searchRegex, '<mark>$1</mark>'); // Замена с учетом регистра
                $(td_content)[0].innerHTML = markedText;
            }
        }
        return true;
    }
    
    //За пуск маркировния текста
    mark_word(search_word, num_col);
});