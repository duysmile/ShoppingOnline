@extends('layout_user.master')
@section('content')
    @include('layout_user.menu_top')
    @include('layout_user.categories')
    @include('layout_user.recommend')
@endsection
@section('dialog')
    @if(isset($token))
        @include('layout_user.dialog_reset_password')
    @endif
@endsection
@section('script')
    <script src="{{asset('js/user/login.js')}}"></script>
    <script src="{{asset('js/user/signup.js')}}"></script>
    <script src="{{asset('js/user/reset_password.js')}}"></script>
    @if(isset($token))
        <script src="{{asset('js/user/send_new_password.js')}}"></script>
    @endif
@endsection
