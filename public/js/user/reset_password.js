$(document).ready(function () {
    $(document).on('focus', 'form#reset-form input', function () {
        $(this).next('span').text("");
    })
    $(document).on('submit', 'form#reset-form', function (e) {
        $(this).find('input').attr('disabled', true);
        e.preventDefault();
        var email = $(this).find('input[name="email_reset"]').val();
        var CSRF_TOKEN = $(this).find('input[name="_token"]').val();
        $('span[data-bind]').text("");
        var _this = $(this);

        $.ajax({
            url: _this.attr('action'),
            contentType: 'application/json',
            dataType: 'json',
            method: _this.attr('method'),
            data: JSON.stringify({
                _token: CSRF_TOKEN,
                email_reset: email,
            }),
            success: function (response) {
                if (!response.success) {
                    console.log(response)
                    var key = Object.keys(response.message)[0];
                    $('span[data-bind="' + key + '"]').text(response.message[key]);
                    Object.keys(response.data).forEach(function (item) {
                        console.log(response.data)
                        $('input[name="' + item + '"]').val(response.data[item]);
                    })
                } else {
                    $('#reset-dialog-content').hide();
                    $('#reset-confirm').show();
                }
            },
            error: function (error) {
                $("#login-register-dialog input").attr("disabled", false);
                var errors = error.responseJSON;
                if (errors.errors != null) {
                    Object.keys(errors.errors).forEach(function (item) {
                        $('span[data-bind="' + item + '"]').text(errors.errors[item]);
                    })
                }
            }
        })
    })
})
