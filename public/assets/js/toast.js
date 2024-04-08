export function show_toast(block){
    $('.toast-container').append(block);
}

export function toast_block(params) {
    var $toast = $(`
    <div class="toast fade show">
        <div class="toast-header">
            <div class="bd-placeholder-img rounded me-2 d-flex justify-content-center align-items-center text-warning" style="background: var(--bs-primary);width: 20px; height: 20px;">
                ${params.logo}
            </div>
            <strong class="me-auto"></strong>
            <small></small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Закрыть"></button>
        </div>
        <div class="toast-body">
        </div>
    </div>
    `);

    //Подстановка текста
    $toast.find('strong').html(params.site);
    $toast.find('small').html(params.time);
    $toast.find('.toast-body').text(params.msg);

    return $toast;
}
/*
class Toast {
    constructor(){

    }
}
*/
