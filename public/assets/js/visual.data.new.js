//Код для того что бы отобразить уведомление о новых данных

const check_interval = 5000;
$(document).ready(function(){
    let  toast_buttons = `
    <div class="mt-2 pt-2 border-top">
      <button type="button" id="toast_update_btn" class="btn btn-primary btn-sm remove-toast" data-bs-dismiss="toast">Обновить</button>
    </div>
    `;

    const get_new_gas_id = setInterval(() => {
        let current_device_id = getCookie('device');
        if (current_device_id > 0){
            let current_data_id = DB_GAS.id;

            getOne('get', {'id':current_device_id}, 'json', BASE_URL + 'api/get/gasData', function(data){
                let new_data_id = data.id;
                if (!($("#toast_update_btn").length > 0)) {
                    if (current_data_id != new_data_id) {
                        toasts.params.msg = `Появились новые данные. Обновить?${toast_buttons}`;
                        toasts.create();
                    }
                }
            });

        }
    }, check_interval);
});