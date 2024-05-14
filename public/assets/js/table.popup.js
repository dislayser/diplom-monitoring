$(document).ready(function() {
    var popup = $("#popup");
    
    let open = popup.find("#popup-open");
    let edit = popup.find("#popup-edit");
    let del  = popup.find("#popup-delete");

    let tr_item = null;

    //Показать КМ
    function show_menu(e){
        popup.show(100).css({
            left: e.pageX,
            top: e.pageY,
        });
    }
    //Скрыть КМ
    function hide_menu(){
        popup.hide(100);
        colored_tr($("tr.table-primary"), 0);
    }

    function popup_edit(){
        let url = tr_item.data("href");
        open.attr("href", url);
        edit.attr("href", url.split('#')[0]);
    }

    //Для удаления
    del.on("click", function(){
        //Данные для отправки запроса
        let post = {
            "delete" : 1,
            "token" : $("#token").val(),
        };

        let url = tr_item.data("href");
        url = url.split('#')[0]

        //Заропрос
        $.ajax({
            url: url,
            method: 'POST', 
            data: post,
        });

        hide_menu();
        tr_item.remove();
    });

    //При нажатии открытии контекстного меню по таблице
    $('tbody tr').on("contextmenu", function (e) {
        e.preventDefault();
        
        tr_item = $(this);
        popup_edit()

        hide_menu();
        colored_tr($(this), 1, "table-primary");
        // Показ КМ
        show_menu(e);
    });
    
    // Скрытие
    $(document).click(function (event) {
        if (!$(event.target).closest(popup).length) {
            hide_menu();
        }
    });

    //Работа с таблицей(Используется для того что бы перекрасить выбранную строку в таблице)
    function colored_tr(item, type = 1, color_class = "table-primary"){
        if (type === 1){
            item.addClass(color_class);
        }
        if (type === 0){
            item.removeClass(color_class);
        }
        return true;
    }
});