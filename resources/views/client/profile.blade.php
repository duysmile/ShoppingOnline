@extends('layout_user.master')

@section('content')
    @include('layout_user.profile')
@endsection

@section('dialog')
    <div class="modal fade" id="delete-dialog" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog rounded-0" role="document">
            <div class="modal-content rounded-0">
                <div class="modal-header rounded-0">
                    <div id="info-dialog-header" class="w-100">
                        <div class="d-flex align-items-center justify-content-between w-100">
                            <h5 class="modal-title color-common" id="exampleModalLabel">{{__('Bạn có chắc chắn muốn hủy đơn hàng?')}}</h5>
                        </div>
                    </div>
                </div>
                <div id="info-dialog-content">
                    <div class="modal-body">
                        <form id="cancel-invoice" action="{{route('invoices-client.cancel')}}" method="post">
                            @csrf
                            <input type="hidden" name="id">
                            <div class="d-flex justify-content-end pt-1">
                                <input type="submit" value="{{__('Có')}}" href="{{route('invoices-client.cancel')}}"
                                       class="b-color-common btn text-white rounded-0 font-size-md"/>
                                <a href="" class="btn bg-light mr-2 rounded-0 font-size-md border" data-dismiss="modal">
                                    {{__('Không')}}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @if(session('payment'))
        <script>
            $(document).ready(function () {
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

                if (tel[0] == '0') {
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
    <script>
        $(document).ready(function () {
            /**
             * init if redirect from payment
             */
            function init() {
                var tab = $('a[data-toggle="tab"]');
                if(tab.attr('active')) {
                    loadInvoices('#in-progress');
                }
            }

            init();

            /**
             * load invoices by status
             * @param tab
             */
            function loadInvoices(tab) {
                var status = 0;
                var token = $('meta[name="csrf-token"]').attr('content');
                switch (tab) {
                    case '#in-progress':
                        status = 0;
                        break;
                    case '#in-transport':
                        status = 1;
                        break;
                    case '#in-transported':
                        status = 2;
                        break;
                    case '#in-success':
                        status = 3;
                        break;
                    case '#in-delete':
                        status = 4;
                        break;
                }

                $.ajax({
                    url: '/invoices/load',
                    dataType: 'json',
                    contentType: 'application/json',
                    method: 'post',
                    data: JSON.stringify({
                        status: status,
                        _token: token
                    }),
                    success: function (response) {
                        console.log(response)
                        $(tab).html(response.view);
                        $('span[data-bind="in-progress"]').text('(' + response.countInProgress + ')');
                        $('span[data-bind="in-transport"]').text('(' + response.countOnTheWay + ')');
                        $('span[data-bind="in-transported"]').text('(' + response.countTransported + ')');
                        $('span[data-bind="in-delete"]').text('(' + response.countCanceled + ')');
                    },
                    error: function (err) {
                        console.log(err);
                    }
                });
            }

            /**
             * event on click tab in invoices
             */
            $(document).on('click', 'a[data-toggle="pill"]', function (e) {
                var tab = $(this).attr('href');

                loadInvoices(tab);
            });

            /**
             * event on click in tab invoice
             */
            $(document).on('click', 'a[href="#invoice"]', function (e) {
                var tab = '#in-progress';

                loadInvoices(tab);
            });

            /**
             * event on click confirm received
             */
            $(document).on('click', 'a#confirm-invoice', function(e){
                e.preventDefault();
                var tab = '#in-transported';
                var id = $(this).attr('data-bind');
                var url = $(this).attr('href');
                var token = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: url,
                    dataType: 'json',
                    contentType: 'application/json',
                    method: 'post',
                    data: JSON.stringify({
                        id: id,
                        _token: token
                    }),
                    success: function (response) {
                        $(tab).html(response.view);
                        console.log(response.view);
                        $('span[data-bind="in-progress"]').text('(' + response.countInProgress + ')');
                        $('span[data-bind="in-transport"]').text('(' + response.countOnTheWay + ')');
                        $('span[data-bind="in-transported"]').text('(' + response.countTransported + ')');
                        $('span[data-bind="in-delete"]').text('(' + response.countCanceled + ')');
                    },
                    error: function (err) {
                        console.log(err);
                    }
                });
            });

            /**
             * attach id to cancel dialog
             */
            $(document).on('click', 'a[data-target="#delete-dialog"]', function(e) {
                var id = $(this).attr('data-bind');
                $('form#cancel-invoice input[name="id"]').val(id);
            });

            /**
             * cancel invoice
             */
            $(document).on('submit', 'form#cancel-invoice', function (e) {
                e.preventDefault();
                var tab = '#in-progress';
                var id = $(this).find('input[name="id"]').val();
                var url = $(this).attr('action');
                var method = $(this).attr('method');
                var token = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: url,
                    dataType: 'json',
                    contentType: 'application/json',
                    method: method,
                    data: JSON.stringify({
                        id: id,
                        _token: token,
                        _method: 'delete'
                    }),
                    success: function (response) {
                        $('#delete-dialog').modal('hide');
                        $(tab).html(response.view);
                        $('span[data-bind="in-progress"]').text('(' + response.countInProgress + ')');
                        $('span[data-bind="in-transport"]').text('(' + response.countOnTheWay + ')');
                        $('span[data-bind="in-transported"]').text('(' + response.countTransported + ')');
                        $('span[data-bind="in-delete"]').text('(' + response.countCanceled + ')');
                    },
                    error: function (err) {
                        console.log(err);
                    }
                });
            });
        })
    </script>
@endsection
