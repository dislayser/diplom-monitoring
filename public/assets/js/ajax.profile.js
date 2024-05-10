$(document).ready(function(){ 
    toasts = new Toast({
        logo: SITE_LOGO,
        site: SITE_NAME_HTML,
        time: 'Только что',
        msg: ''
    });

    //Получение данных профиля
    getOne('get', [], 'json', $('form').attr('action'), function(data){
        to_form(data);
    });
    //Вставка данных
    function to_form(data){
        $('#id').text(data.id)
        $('#login').val(data.login);
        $('#name').val(data.name);
        $('#theme').val(data.theme);
        $('#ip').val(data.ip);
        $('#rule').val(data.rule);
    }

    //Отправка данных
    $('form').submit(function(e){
        let modal = $('#modal_password');
        // Предотвращаем стандартное поведение формы (перезагрузку страницы)
        e.preventDefault();
        var form_data = $(this).serialize();
        console.log(form_data);

        put('post', form_data, $(this).attr('action'), function(data){
            if(data.status == 200){
                toasts.params.msg = 'Данные сохранены.';
            }else{
                toasts.params.msg = 'Ошибка выполнения запроса.';
            }
            $('form').find(":submit[name='" + e.originalEvent.submitter.name + "']").prop('disabled', false);
            toasts.create();

            //очистка полей модала
            modal.find("input").val("");
            modal.modal('hide');
        });

    });
});