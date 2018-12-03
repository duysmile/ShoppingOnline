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

            $(document).on('input', 'input[data-items]', function() {
                var id = $(this).attr('data-items');
                var price = $('span[data-id="' + id + '"][data-price-one]').attr('data-price-one');
                var qty = $(this).val();
                var total = Number(price) * qty;

                $('span[data-id="' + id + '"][data-price]').text(money(total + '000'))
            });

            $(document).on('change', 'input[data-items]', function() {
                var id = $(this).attr('data-items');
                var qty = $(this).val();
                var token = $('meta[name="csrf-token"]').attr('content');
                var method = 'patch';

                $.ajax({
                    url: '{{route('update-cart')}}',
                    dataType: 'json',
                    contentType: 'application/json',
                    method: 'post',
                    data: JSON.stringify({
                        id: id,
                        qty: qty,
                        _token: token,
                        _method: method
                    }),
                    success: function(response) {
                    },
                    error: function(err) {
                    }
                });
            })
        })
    </script>
@endsection
