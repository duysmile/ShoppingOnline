$(document).ready(function () {
    $('#new-password-dialog').modal('show');
    $('#new-password-confirm-content').hide();
    $('#new-password-content').show();
    $(document).on('submit', 'form#new-password-form', function (e) {
        $(this).find('input').attr('disabled', true);
        e.preventDefault();
        var new_password = $(this).find('input[name="password"]').val();
        var confirm_password = $(this).find('input[name="confirm-password"]').val();
        var CSRF_TOKEN = $(this).find('input[name="_token"]').val();
        var token = $(this).find('input[name="token"]').val();
        var _this = $(this);
        $('span[data-bind]').text("");
        $.ajax({
            url: _this.attr('action'),
            contentType: 'application/json',
            dataType: 'json',
            method: _this.attr('method'),
            data: JSON.stringify({
                _token: CSRF_TOKEN,
                token: token,
                password: new_password,
                password_confirmation: confirm_password,
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
                    $('#new-password-content').hide();
                    $('#new-password-confirm-content').show();
                }
            },
            error: function (error) {
                _this.find('input').attr('disabled', false);
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
