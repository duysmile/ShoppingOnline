<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{asset('css/bootstrap/bootstrap.min.css')}}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    <style>
        /*common*/
        a {
            color: #000;
        }
        a:hover {
            color: #000;
            text-decoration: none;
        }
        .bg-common {
            background: #ff6a00;
        }
        .btn-common{
            padding: 8px 20px !important;
            font-size: 18px;
            color: #1d2124;
            transition: background-color 0.3s ease;
        }
        .btn-common:hover{
            background: #ff6a00;
            color: #fff;
            -webkit-box-shadow: 1px 1px 5px 1px #c8cbcf;
            -moz-box-shadow: 1px 1px 5px 1px #c8cbcf;
            box-shadow: 1px 1px 5px 1px #c8cbcf;
        }
        .border-common-lg {
            border: 2px solid #ff6a00;
        }
        /*detail*/
        .nav__input-search:focus {
            border-color: #ff6a00 !important;
            box-shadow: none;
        }
        .nav__menu--box-shadow {
            box-shadow:1px 2px 1px #c8cbcf;
        }
        .nav__categories--padding {
            padding: 10px;
        }
        .nav__button h4 {
            margin: 0;
            padding: 0;
            font-size: 20px;
            font-weight: normal;
        }
        .nav__button:hover {
            border-top: 1px solid #ccc;
            border-left: 1px solid #ccc;
            border-right: 1px solid #ccc;
        }
        body {
            height: 1500px;
        }
        header.main-header--height{
            height: 20vh;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="container-fluid main-header--height d-flex justify-content-between align-items-center">
        <div class="h-100 mr-3">
            <img class="h-100" src="{{asset('images/logo.jpg')}}" alt="Logo here">
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
    <nav class="navbar navbar-expand-sm navbar-light sticky-top bg-white nav__menu--box-shadow">
        <button class="navbar-toggler border bg-light" type="button" data-toggle="collapse" data-target="#navMenu">
            <span class="navbar-toggler-icon "></span>
        </button>
        <div class="collapse navbar-collapse w-100" id="navMenu">
            <div class="d-flex flex-md-row flex-column justify-content-md-around align-items-md-center w-100">
                <div class="nav__button nav__categories--padding">
                    <h4>
                        <i class="fa fa-list pr-2"></i>
                        <a class="text-dark" href="#">Categories</a>
                    </h4>
                </div>
                <div class="w-50">
                    <form action="" class="form-inline w-100">
                        <div class="input-group w-100 border-common-lg">
                            <input type="text" class="form-control border-0 nav__input-search" placeholder="What are you looking for ... ">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-common text-white border-0">
                                    <i class="fa fa-search pr-2 text-white"></i>
                                    Search
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="d-flex">
                    <div class="nav__button p-2">
                        <i class="fa fa-user p-2"></i>
                        <a href="">
                            Login <span style="color:#ccc">|</span> Sign up free
                        </a>
                    </div>
                    <div class="nav__button p-2">
                        <i class="fa fa-shopping-cart p-2"></i>
                        <a href="">
                            Cart
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="container bg-light">
        Hello
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script type="text/javascript" src="{{asset('js/jquery/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/bootstrap/bootstrap.min.js')}}"></script>
</body>
</html>
