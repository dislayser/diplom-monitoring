$(document).ready(function() {
    const table_titel = $('#table-titel');
    const current_table = $('#AdminSidebar a.active').text();
    console.log(current_table);
    if (current_table){
        table_titel.removeClass('d-none')
        table_titel.find('span').text(current_table);    
    }else{
        table_titel.addClass('d-none');
    }
});