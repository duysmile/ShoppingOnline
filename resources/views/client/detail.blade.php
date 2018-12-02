@extends('layout_user.master')

@section('content')
    @include('layout_user.detail')
    @include('layout_user.recommend')
@endsection

@section('dialog')
    @component('layout_user.notice')
        <i class="fa fa-check text-success"></i>
        <span class="text-white">
            {{__('Sản phẩm đã thêm vào giỏ hàng')}}
        </span>
    @endcomponent
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('#add-cart-button').on('click', function (e) {
                e.preventDefault();
                var id = $(this).parent().attr('data-id');
                var url = $(this).parent().parent('form').attr('action');
                var method = $(this).parent().parent('form').attr('method');
                var qty = $(this).parent().parent('form').find('input[name="qty"]').val();
                var token = $('meta[name="csrf-token"]').attr('content');
                //TODO: add to cart
                $.ajax({
                    url: url,
                    method: method,
                    dataType: 'json',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        id: id,
                        qty: qty,
                        _token: token
                    }),
                    success: function (response) {
                        console.log(response);
                        if (response.success) {
                            $('.notice-common').show();
                            $('#count-cart-items').html(response.count);
                            setTimeout(function(){
                                $('.notice-common').hide();
                            }, 3000);
                        }
                    },
                    error: function (err) {
                        console.log(err);
                    }
                });
            });
            $('#buy-button').on('click', function (e) {

            });
        });
    </script>
@endsection
