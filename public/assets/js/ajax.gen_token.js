//import { show_toast, toast_block } from './toast.js';
$(document).ready(function() {
    if ($('label[for="api_token"]').length) {
        // Создаем блок div с классом "d-flex gap-2"
        var container = $('<div class="d-flex gap-2"></div>');

        // Находим поле ввода с id="api_token"
        var api_input = $('#api_token');

        // Создаем кнопку
        var button = $('<button type="button" data-tooltip="Генерировать токен" id="new_token" class="btn btn-outline-secondary"><i class="bi-command"></i></button>');

        // Перемещаем поле ввода и кнопку в блок div
        container.append(api_input);
        container.append(button);
        $('label[for="api_token"]').after(container);
    }

    //Обработка кнопки генерирования токена
    $(document).on('click', '#new_token', function(){
        var api_input = $('#api_token');

        getOne('get', {'length' : 32}, 'json', BASE_URL + 'ajax/GenApi', function(data){
            var api_input = $('#api_token');
            api_input.val(data.api_token)
        });
    });
});