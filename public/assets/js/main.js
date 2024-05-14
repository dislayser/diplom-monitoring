//import { show_toast, toast_block } from './toast.js';
//Создание обьекта тоаст
let toasts;
$(document).ready(function() {
    toasts = new Toast({
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


    if (window.location.hash === '#view') {
        // Находим все поля ввода на странице и делаем их неактивными
        $('input, select, textarea').prop('disabled', true);
        $('button:submit').hide();
        $('a#go-edit').show();
    }
});

// Функция для получения значения куки по имени
function getCookie(name) {
    const cookieValue = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
    return cookieValue ? cookieValue[2] : null;
}

// Функция для записи значения куки
function setCookie(name, val){
    document.cookie = name +"=" + val + "; expires=" + new Date(Date.now() + 30 * 24 * 60 * 60 * 1000).toUTCString() + "; path=/";
}
    
//Переход на другую страницу
function go(url = BASE_URL){
    if (url !== window.location.href) {
        window.location.href = url;
    }
}

const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
