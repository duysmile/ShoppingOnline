$(document).ready(function() {
    //change dialog
    $(document).on('click', '[data-open]', function (e) {
        e.preventDefault();
        var tab = $(this).attr('data-open');
        if (tab == 'signup') {
            $('#signup-dialog-header').show();
            $('#login-dialog-header').hide();
            $('#reset-dialog-header').hide();
            $('#signup-dialog-content').show();
            $('#login-dialog-content').hide();
            $('#reset-dialog-content').hide();
            $('#reset-confirm').hide();
        } else if(tab == 'login') {
            $('#signup-dialog-header').hide();
            $('#login-dialog-header').show();
            $('#reset-dialog-header').hide();
            $('#signup-dialog-content').hide();
            $('#login-dialog-content').show();
            $('#reset-dialog-content').hide();
            $('#reset-confirm').hide();
        } else {
            $('#signup-dialog-header').hide();
            $('#login-dialog-header').hide();
            $('#reset-dialog-header').show();
            $('#signup-dialog-content').hide();
            $('#login-dialog-content').hide();
            $('#reset-dialog-content').show();
            $('#reset-confirm').hide();
        }
    })

    $(document).on('focus', 'form#login-form input', function () {
        $('span[data-bind]').text("");
    })
    $(document).on('submit', 'form#login-form', function (e) {
        e.preventDefault();
        var url_current = window.location.pathname;
        var id_login = $(this).find('input[name="id_login"]').val();
        var pass_login = $(this).find('input[name="pass_login"]').val();
        var remember_me = $(this).find('input[name="remember_me"]').is(":checked");
        var CSRF_TOKEN = $(this).find('input[name="_token"]').val();
        var _this = $(this);
        $('span[data-bind]').text("");

        $.ajax({
            url: _this.attr('action'),
            contentType: 'application/json',
            method: _this.attr('method'),
            dataType: 'json',
            data: JSON.stringify({
                _token: CSRF_TOKEN,
                id_login: id_login,
                pass_login: pass_login,
                remember_me: remember_me
            }),
            success: function (response) {
                if (!response.success) {
                    var key = Object.keys(response.message)[0];
                    $('span[data-bind="'+ key +'"]').text(response.message[key]);
                    Object.keys(response.data).forEach(function(item) {
                        $('input[name="'+ item +'"]').val(response.data[item]);
                    })
                } else {
                    window.location.href = url_current;
                }
            },
            error: function (error) {
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
