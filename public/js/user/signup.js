$(document).ready(function () {
    $(document).on('submit', 'form#signup-form', function (e) {
        e.preventDefault();
        var username = $('input[name="username"]').val();
        var password = $('input[name="password"]').val();
        var confirm_password = $('input[name="confirm-password"]').val();
        var tel = $('input[name="tel"]').val();
        var email = $('input[name="email"]').val();
        var CSRF_TOKEN = $('input[name="_token"]').val();

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
                console.log(response)
            },
            error: function (error) {
                console.log(error)
            }
        })
    })
})
