@extends('layout_user.master')

@section('content')
    @include('layout_user.detail')
    @include('layout_user.recommend')
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#add-cart-button').on('click', function(e) {
                e.preventDefault();
                var id = $(this).parent().attr('data-id');
                var url = $(this).parent().parent('form').attr('action');
                var method = $(this).parent().parent('form').attr('method');
                var token = $('meta[name="csrf-token"]').attr('content');
                //TODO: add to cart
                $.ajax({
                    url: url,
                    method: method,
                    dataType: 'json',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        id: id,
                        _token: token
                    }),
                    success: function(response) {
                        console.log(response);
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            });
            $('#buy-button').on('click', function(e) {

            });
        });
    </script>
@endsection
