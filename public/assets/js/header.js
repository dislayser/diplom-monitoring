const $header = $("header");

const current_url = window.location.origin + window.location.pathname;

$($header).ready(function() {
    var nav_items = $header.find('ul li a');
    nav_items.removeClass('active');

    active_nav(nav_items);
});

//Активируем элемент панели
function active_nav(items){
    for (var i = 0; i < items.length; i++) {
        var a_href = $(items[i]).attr('href');
        if (a_href == current_url){
            $(items[i]).addClass('active');
            return true;
        }
    }
    return false;
}