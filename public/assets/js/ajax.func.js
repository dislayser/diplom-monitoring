function getOne(method = 'get', data = [], data_type = 'json', url = $('form').attr('action'), successCallback) {
    $.ajax({
        url: url,
        method: method, 
        dataType: data_type,
        data: data,
        success: function(data) {
            if (successCallback) {
                successCallback(data);
            }
        },
        error: function(xhr, status, error) {
            console.error('Ошибка: ' + error);
        }
    });
}

function put(method = 'post', data = [], url = $('form').attr('action'), successCallback) {
    $.ajax({
        url: url,
        method: method, 
        data: data,
        success: function(data) {
            if (successCallback) {
                successCallback(data);
            }
        },
        error: function(xhr, status, error) {
            console.error('Ошибка: ' + error);
        }
    });
}
