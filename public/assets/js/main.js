//import { show_toast, toast_block } from './toast.js';

$(document).ready(function() {
    //Создание обьекта тоаст
    let toasts = new Toast({
        logo: SITE_LOGO,
        site: SITE_NAME_HTML,
        time: 'Только что',
        msg: ''
    });

    //Динамичное изменение темы
    $('#theme').change(function(){
        var new_css = '';
        var selected_theme = $('#theme').val().trim();
        if (selected_theme){
            new_css = '/themes/' + selected_theme;
        }
        new_css = BASE_URL + 'assets/css' + new_css + '/bootstrap.min.css';
        $('link#main_css').attr('href', new_css);
    });


    //Для копирования
    $(document).on('click', '#copy[data-target]', function(){
        var target = $(this).data('target'); //Определяет конечный элемент
        var parent = $(this).data('parent'); //Для поиска кон элемента внутри родителя
        var block = $(this).closest(parent).find(target);
        
        block.select();
        if (document.execCommand("copy")){
            toasts.params.msg = 'Скопировано.';
            toasts.create();
        };
    });

});
