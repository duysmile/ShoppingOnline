<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    @yield('head-meta')

    <title>Shopping Online - Dashboard</title>

    <!-- Bootstrap core CSS-->
    <link href="{{asset('css/bootstrap/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">

    <!-- Custom styles for this template-->
    <link href="{{asset('css/admin/sb-admin.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
    @yield('style')

    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('js/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('js/bootstrap/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/admin/Chart.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>

</head>

<body id="page-top">

@include('layout_admin.header')

<div id="wrapper">

    <!-- Sidebar -->
    @include('layout_admin.sidebar')

    <div id="content-wrapper">

        <div class="container-fluid">
            @yield('content')
        </div>
        <!-- /.container-fluid -->

        <!-- Sticky Footer -->
        @include('layout_admin.footer')

    </div>
    <!-- /.content-wrapper -->

</div>
<!-- /#wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="login.html">Logout</a>
            </div>
        </div>
    </div>
</div>

<!-- Custom scripts for all pages-->
<script src="{{asset('js/admin/sb-admin.min.js')}}"></script>
@yield('js')

</body>

</html>

