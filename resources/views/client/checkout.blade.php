<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{csrf_token()}}">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{asset('css/bootstrap/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/header.css')}}">
    <link rel="stylesheet" href="{{asset('css/menu-top.css')}}">
    <link rel="stylesheet" href="{{asset('css/categories.css')}}">
    <link rel="stylesheet" href="{{asset('css/footer.css')}}">
    <link rel="stylesheet" href="{{asset('css/cart.css')}}">
    <link rel="stylesheet" href="{{asset('css/profile.css')}}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css"
          integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
</head>
<body class="bg-light">

<!-- Header -->
<header class="container-fluid main-header--height d-flex justify-content-between align-items-center bg-white">
    <div class="h-100 pr-4 mr-5 ml-1 pl-5">
        <a href="/">
            <img class="h-100" src="{{asset('images/logo.jpg')}}" alt="Logo here">
        </a>
    </div>
    <nav class="navbar navbar-expand-sm">
        <div class="collapse navbar-collapse" id="nav-menu">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link btn-common" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn-common" href="#">Contact</a>
                </li>
            </ul>
        </div>
    </nav>
</header>

<!-- Navbar -->
<nav class="navbar navbar-expand-sm navbar-light sticky-top bg-white nav__menu--box-shadow pt-0 mt-0">
    <button class="navbar-toggler border bg-light" type="button" data-toggle="collapse" data-target="#navMenu">
        <span class="navbar-toggler-icon "></span>
    </button>
    <div class="collapse navbar-collapse w-100" id="navMenu">
        <div class="container d-flex flex-md-row flex-column justify-content-md-between align-items-md-center w-100">
            <h4 class="color-common font-weight-normal">
                {{__('SHOPPING ONLINE | THANH TOÁN')}}
            </h4>
            <div class="d-flex justify-content-end">
                <div class="nav__button position-relative custom-dropdown-block pt-2">
                    <i class="fa fa-user p-2 color-common"></i>
                    <a href="{{route('profile-user')}}">
                        {{Auth::user()->name}}
                    </a>
                    <div class="custom-dropdown-menu custom-dropdown-menu-right">
                        <ul>
                            @role('admin', 'staff')
                            <li class="border-bottom">
                                <a href="{{route('admin')}}" class="text-white">{{__('Đến trang quản trị')}}</a>
                            </li>
                            @endrole
                            <li class="border-bottom">
                                <a href="{{route('profile-user')}}"
                                   class="text-white">{{__('Tài khoản của tôi')}}</a>
                            </li>
                            <li>
                                <a href="{{route('logout')}}" class="text-white">{{__('Đăng xuất')}}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>


@if(session('success'))
    <div class="alert alert-success text-center">
        {{session('success')}}
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger text-center">
        {{session('error')}}
    </div>
@endif

<div id="content-cart">
    @include('layout_user.checkout')
</div>

<!-- Footer -->
@include('layout_user.footer')
<!-- End Footer -->

<!-- Dialog -->
<div class="modal fade" id="change-info-dialog" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog rounded-0" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header rounded-0">
                <div id="info-dialog-header" class="w-100">
                    <div class="d-flex align-items-center justify-content-between w-100">
                        <h5 class="modal-title color-common" id="exampleModalLabel">{{__('Thay đổi địa chỉ')}}</h5>
                    </div>
                </div>
            </div>
            <div id="info-dialog-content">
                <div class="modal-body">
                    <form id="info-form">
                        @csrf
                        <div class="form-group">
                            <select name="city" type="text" class="form-control rounded-0 font-size-md" required>
                            </select>
                            <span class="text-danger" data-bind="city"></span>
                        </div>
                        <div class="form-group">
                            <select name="district" type="text" class="form-control rounded-0 font-size-md" required>
                            </select>
                            <span class="text-danger" data-bind="district"></span>
                        </div>
                        <div class="form-group">
                            <select name="guild" type="text" class="form-control rounded-0 font-size-md" required>
                            </select>
                            <span class="text-danger" data-bind="guild"></span>
                        </div>
                        <div class="form-group">
                            <input name="street" type="text" class="form-control rounded-0 font-size-md"
                                   placeholder="{{__('Tòa nhà/Tên đường')}}">
                            <span class="text-danger" data-bind="street"></span>
                        </div>
                        <div class="d-flex justify-content-end pt-5">
                            <a href="" class="btn bg-light mr-2 rounded-0 font-size-md border" data-dismiss="modal">
                                Trở lại
                            </a>
                            <input type="submit" value="{{__('Hoàn thành')}}" href=""
                                   class="b-color-common btn text-white rounded-0 font-size-md"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Dialog -->

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script type="text/javascript" src="{{asset('js/jquery/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/bootstrap/bootstrap.min.js')}}"></script>

<script src="{{asset('js/user/moneyConvert.js')}}"></script>
<script src="{{asset('js/user/address.js')}}"></script>

<script>
    $(document).ready(function () {

        var code_city = '';
        var code_district = '';
        var code_guild = '';

        /**
         * template for option select
         * @param code
         * @param name
         * @returns {string}
         */
        function tplOption(code, name) {
            var template = '<option value="{code}">{name}</option>';
            template = template.replace('{code}', code);
            template = template.replace('{name}', name);
            return template;
        }

        /**
         * get info from address.js city, district, guild
         * @param optionTpl
         * @param information
         * @returns {*}
         */
        function getInfo(optionTpl, information) {
            var infos = Object.keys(information).map(function (item) {
                var name = information[item].name;
                var code = item;
                return {
                    code: code,
                    name: name
                };
            });
            infos.forEach(function (item) {
                optionTpl += tplOption(item.code, item.name);
            })
            return optionTpl;
        }

        /**
         * init page
         */
        function init() {
            $('select[name="district"]').attr('disabled', true);
            $('select[name="guild"]').attr('disabled', true);

            var optionCities = '<option selected disabled hidden>Tỉnh/Thành phố</option>';
            var optionDistricts = '<option selected disabled hidden>Quận/Huyện</option>';
            var optionGuilds = '<option selected disabled hidden>Phường/Xã</option>';

            optionCities = getInfo(optionCities, info);

            $('select[name="city"]').html(optionCities);
            $('select[name="district"]').html(optionDistricts);
            $('select[name="guild"]').html(optionGuilds);
        }

        /**
         * on change event select city
         */
        $(document).on('change', 'select[name="city"]', function (e) {
            $('span[data-bind]').text('');
            var code = $(this).val();

            var optionDistricts = '<option selected disabled hidden>Quận/Huyện</option>';

            optionDistricts = getInfo(optionDistricts, info[code]['quan-huyen']);

            $('select[name="district"]').html(optionDistricts);
            $('select[name="district"]').attr('disabled', false);

            code_city = code;
        });

        /**
         * on change event select district
         */
        $(document).on('change', 'select[name="district"]', function (e) {
            $('span[data-bind]').text('');

            var code = $(this).val();

            var optionGuild = '<option selected disabled hidden>Phường/Xã</option>';

            optionGuild = getInfo(optionGuild, info[code_city]['quan-huyen'][code]['xa-phuong']);

            $('select[name="guild"]').html(optionGuild);
            $('select[name="guild"]').attr('disabled', false);

            code_district = code;
        });

        /**
         * on change event select guild
         */
        $(document).on('change', 'select[name="guild"]', function (e) {
            $('span[data-bind]').text('');
            var code = $(this).val();

            code_guild = code;
        });

        $(document).on('input', 'input[name="street"]', function () {
            $('span[data-bind]').text('');
        })

        init();

        /**
         * on submit change info address
         */
        $(document).on('submit', 'form#info-form', function (e) {
            e.preventDefault();
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

            var address = info[code_city]['quan-huyen'][code_district]['xa-phuong'][code_guild].name_with_type + ', ';
            address += info[code_city]['quan-huyen'][code_district].name_with_type + ', ';
            address += info[code_city].name_with_type;

            address = street + ' ' + address;
            $('input[type="hidden"][name="address"]').val(address);
            $('span.address').text(address);

            $('#change-info-dialog').modal('hide');
        });
    })
</script>

</body>
</html>
