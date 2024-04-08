import { show_toast, toast_block } from './toast.js';

$(document).ready(function() {
    var form_submitted = false;

    //Отправка формы
    $("form").submit(function(event) {
        if (form_submitted) {
            event.preventDefault(); // Блокируем повторное отправление формы
        } else {
            form_submitted = true;
            var $submit_btn = $(this).find(":submit[name='" + event.originalEvent.submitter.name + "']")
            // Сохраняем стилевые классы кнопки перед скрытием
            var style = $submit_btn.attr('class');
            var text = $submit_btn.text();
            // Форма отправлена
            var btn_type = 1;
            if ($($submit_btn).attr('name') === 'btn-search') {
                btn_type = 2;
            }
            $submit_btn.hide().after(load_btn(style, btn_type));
        }
    });

    //Кнопка загрузки
    function load_btn(style, type = 1) {
        if (type === 1) {
            var btn = `<span role="status">Загрузка...</span>`;
        }else if (type === 2){
            var btn = ``;
        }
        return ` 
        <button class="${style}" type="button" disabled>
            <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
            ${btn}
        </button>`;
    }

    //Для копирования
    $(document).on('click', '#copy[data-target]', function(){
        var target = $(this).data('target'); //Определяет конечный элемент
        var parent = $(this).data('parent'); //Для поиска кон элемента внутри родителя
        var block = $(this).closest(parent).find(target);
        
        block.select();
        if (document.execCommand("copy")){
            var block = toast_block({
                logo: SITE_LOGO,
                site: SITE_NAME_HTML,
                time: 'Только что',
                msg: 'Скопировано.'
            });
            show_toast(block);
        };
    });

});
