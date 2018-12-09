@extends('layout_user.master')

@section('content')
    @include('layout_user.profile')
@endsection

@section('script')
    @if(session('payment'))
        <script>
            $(document).ready(function() {
                localStorage.clear();
            })
        </script>
    @endif
    <script src="{{asset('js/user/address.js')}}"></script>
    <script src="{{asset('js/user/selectAddress.js')}}"></script>
    <script>
        $(document).ready(function () {
            /**
             * convert tel no when has change
             */
            $(document).on('change', 'input[name="tel"]', function () {
                var tel = $(this).val().trim();

                if(tel[0] == '0') {
                    tel = '(+84)' + tel.slice(1);
                }
                $(this).val(tel);
            });

            /**
             * signup form
             */
            $(document).on('submit', 'form#change-info', function (e) {
                e.preventDefault();
                var name = $(this).find('input[name="name"]').val();
                var tel = $(this).find('input[name="tel"]').val();
                var address = '';
                if (code_city == '' && code_district == '' && code_guild == '') {
                    address = $(this).find('input[type="hidden"][name="curAddress"]').val();
                } else {
                    if (code_city == '') {
                        $('span[data-bind="city"]').text('Chọn tỉnh/thành phố là bắt buộc');
                        return;
                    }
                    if (code_district == '') {
                        $('span[data-bind="district"]').text('Chọn quận/huyện là bắt buộc');
                        return;
                    }
                    if (code_guild == '') {
                        $('span[data-bind="guild"]').text('Chọn phường/xã là bắt buộc');
                        return;
                    }

                    var street = $(this).find('input[name="street"]').val();

                    if (street == '') {
                        $('span[data-bind="street"]').text('Địa chỉ là bắt buộc');
                        return;
                    }

                    address = info[code_city]['quan-huyen'][code_district]['xa-phuong'][code_guild].name_with_type + ', ';
                    address += info[code_city]['quan-huyen'][code_district].name_with_type + ', ';
                    address += info[code_city].name_with_type;

                    address = street + ' ' + address;
                }

                var gender = $(this).find('input[name="gender"]').val();
                var email = $(this).find('input[name="email"]').val();
                var birth_date = $(this).find('input[name="birth_date"]').val();
                console.log(birth_date)
                var CSRF_TOKEN = $(this).find('input[name="_token"]').val();
                $('span[data-bind]').text("");
                $(this).find("input").attr("disabled", true);
                var _this = $(this);

                $.ajax({
                    url: _this.attr('action'),
                    contentType: 'application/json',
                    dataType: 'json',
                    method: _this.attr('method'),
                    data: JSON.stringify({
                        _token: CSRF_TOKEN,
                        name: name,
                        address: address,
                        gender: gender,
                        tel: tel,
                        birth_date: birth_date,
                        email: email
                    }),
                    success: function (response) {
                        $(_this).find("input").attr("disabled", false);
                        if (!response.success) {
                            var key = Object.keys(response.message)[0];
                            $('span[data-bind="' + key + '"]').text(response.message[key]);
                        } else {
                            $('span#notice-success').text(response.message);
                            $('span#address').text(address);
                        }
                    },
                    error: function (error) {
                        $(_this).find("input").attr("disabled", false);
                        var errors = error.responseJSON;
                        if (errors.errors != null) {
                            Object.keys(errors.errors).forEach(function (item) {
                                $('span[data-bind="' + item + '"]').text(errors.errors[item]);
                            })
                        }
                    }
                })
            })
        });

    </script>
@endsection
