$(document).ready(function () {
    var errMsg = $('#error');
    const passwordInput = $("#password");
    const icon = $("#toggle-password-icon");

    $("#toggle-password-icon").click(function () {
        if (passwordInput.attr("type") === "password") {
            passwordInput.attr("type", "text");
            icon.fadeOut(10, function () {
                icon.removeClass("bi-eye").addClass("bi-eye-slash").fadeIn(200);
            });
        } else {
            passwordInput.attr("type", "password");
            icon.fadeOut(10, function () {
                icon.removeClass("bi-eye-slash").addClass("bi-eye").fadeIn(200);
            });
        }
    });

    //Убираем валидацию
    function clear_error(){
        $('#error').text('');
    }
    $(document).on("input", '#login', function(){
        clear_error();
    });
    $(document).on("input", '#password', function(){
        clear_error();
    });
});