$(document).ready(function () {
    $(document).on('focus', 'form#signup-form input', function () {
        $(this).next('span').text("");
    })
    $(document).on('submit', 'form#signup-form', function (e) {
        e.preventDefault();
        var username = $(this).find('input[name="username"]').val();
        var password = $(this).find('input[name="password"]').val();
        var confirm_password = $(this).find('input[name="confirm-password"]').val();
        var tel = $(this).find('input[name="tel"]').val();
        var email = $(this).find('input[name="email"]').val();
        var CSRF_TOKEN = $(this).find('input[name="_token"]').val();
        $('span[data-bind]').text("");
        $("#login-register-dialog input").attr("disabled", true);
        var _this = $(this);

        $.ajax({
            url: _this.attr('action'),
            contentType: 'application/json',
            dataType: 'json',
            method: _this.attr('method'),
            data: JSON.stringify({
                _token: CSRF_TOKEN,
                username: username,
                password: password,
                password_confirmation: confirm_password,
                tel: tel,
                email: email
            }),
            success: function (response) {
                if (!response.success) {
                    var key = Object.keys(response.message)[0];
                    $('span[data-bind="'+ key +'"]').text(response.message[key]);
                    Object.keys(response.data).forEach(function(item) {
                        $('input[name="'+ item +'"]').val(response.data[item]);
                    })
                } else {
                    alert(response.message);
                    window.location.href = "/";
                }
            },
            error: function (error) {
                $("#login-register-dialog input").attr("disabled", false);
                var errors = error.responseJSON;
                if (errors.errors != null){
                    Object.keys(errors.errors).forEach(function(item) {
                        $('span[data-bind="'+ item +'"]').text(errors.errors[item]);
                    })
                }
            }
        })
    })
})
