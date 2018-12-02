@extends('layout_user.master')

@section('content')
    @include('layout_user.cart')
    @include('layout_user.recommend')
@endsection

@section('script')
    <script src="{{asset('js/user/moneyConvert.js')}}"></script>
    <script>
        $(document).ready(function() {
            var totalPrice = 0;
            $('.price-products').each(function (item) {
                var price = $(this).attr('data-price');
                totalPrice += parseFloat(price);
            });

            $('.totalPrice').html(money(totalPrice + '000'));
        })
    </script>
@endsection
