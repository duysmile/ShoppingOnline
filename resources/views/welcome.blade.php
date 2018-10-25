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
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/header.css')}}">
    <link rel="stylesheet" href="{{asset('css/menu-top.css')}}">
    <link rel="stylesheet" href="{{asset('css/categories.css')}}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    <style>
        /*common*/

        /*detail*/

        body {
            height: 1500px;
        }
    </style>
</head>
<body class="bg-light">
    <!-- Header -->
    @include('layout_user.header')
    <!-- End Header -->

    <!-- Content -->
        <!-- Menu Top -->
        @include('layout_user.menu_top')
        <!-- Top Categories -->
        @include('layout_user.categories')
    <!-- End Content -->

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script type="text/javascript" src="{{asset('js/jquery/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/bootstrap/bootstrap.min.js')}}"></script>
</body>
</html>
