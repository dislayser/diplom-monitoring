$(document).ready(function(){
    
    let profile_toasts = new Toast({
        logo: SITE_LOGO,
        site: SITE_NAME_HTML,
        time: 'Только что',
        msg: 'Данные сохранены.'
    });

    //Получение данных профиля
    getOne('get', [], 'json', $('form').attr('action'), function(data){
        to_form(data);
    });
    //Вставка данных
    function to_form(data){
        $('#login').val(data.login);
        $('#name').val(data.name);
        $('#theme').val(data.theme);
    }

    //Отправка данных
    $('form').submit(function(e){
        // Предотвращаем стандартное поведение формы (перезагрузку страницы)
        e.preventDefault();
        var form_data = $(this).serialize();

        put('post', form_data, $(this).attr('action'), function(data){
            if(data.status == 200){
                profile_toasts.params.msg = 'Данные сохранены.';
            }else{
                profile_toasts.params.msg = 'Ошибка запроса.';
            }
            console.log(e);
            $('form').find(":submit[name='" + e.originalEvent.submitter.name + "']").prop('disabled', false);
            profile_toasts.create();
        });
    });
});