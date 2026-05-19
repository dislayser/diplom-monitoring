$(document).ready(function () {
    const pass_old = $("#password_old");
    const pass_new = $("#password_new");
    const pass_rep = $("#password_repeat");
    const btn_pass = $('button[name="change_password"]')

    const err_msg = $("span#error");
    err_msg.hide();

    pass_old.on("input", function(){
        //console.log("pass_old");
    });
    pass_new.on("input", function(){
    });
    pass_rep.on("input", function(){
        if(pass_new.val() !== pass_rep.val()){
            btn_pass.prop("disabled", true);
            err_msg.show('fast');
            err_msg.text("Пароли не совпадают");
        }else{
            btn_pass.prop("disabled", false);
            err_msg.text("");
            err_msg.hide('fast');
        }
    });
});