@extends('layout_user.master')

@section('content')
    <div id="content-cart">
        @include('layout_user.cart')
    </div>
    @include('layout_user.recommend')
@endsection

@section('dialog')
    <div class="modal px-2" id="dialog-delete">
        <div class="modal-dialog margin-dialog rounded-0">
            <div class="modal-content rounded-0">
                <!-- Modal body -->
                <div class="modal-body rounded-0">
                    <h5 class="color-common font-weight-normal">
                        Bạn có chắc chắn muốn xóa sản phẩm này?
                    </h5>
                    <p class="product-name">

                    </p>
                    <form action="{{route('delete-item-card')}}" method="post" class="w-100 d-flex mt-5">
                        <input type="hidden" value="delete" name="_method">
                        <input type="hidden" value="" name="id">
                        <input type="submit" class="btn bg-common text-white w-50 rounded-0 border-common"
                               value="{{__('Có')}}">
                        <button type="button" class="btn bg-white w-50 rounded-0 border"
                                data-dismiss="modal">{{__('Không')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{asset('js/user/moneyConvert.js')}}"></script>
    <script>
        $(document).ready(function() {
            function countTotalPrice() {
                var totalPrice = 0;
                $('.price-products').each(function (item) {
                    var price = $(this).attr('data-price');
                    totalPrice += parseFloat(price);
                });

                $('.totalPrice').html(money(totalPrice + '000'));
            }

            countTotalPrice();

            $(document).on('input', 'input[data-items]', function() {
                var id = $(this).attr('data-items');
                var price = $('span[data-id="' + id + '"][data-price-one]').attr('data-price-one');
                var qty = $(this).val();
                var total = Number(price) * qty;

                $('span[data-id="' + id + '"][data-price]').text(money(total + '000'));
                $('span[data-id="' + id + '"][data-price]').attr('data-price', total);
                countTotalPrice();
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
            });

            $(document).on('click', 'a.delete-item-card', function (e) {
                var id = $(this).attr('data-id');
                $('#dialog-delete input[name="id"]').val(id);
            });

            $(document).on('submit', '#dialog-delete form', function(e) {
                e.preventDefault();
                var url = $(this).attr('action');
                var id = $(this).find('input[name="id"]').val();
                var token = $('meta[name="csrf-token"]').attr('content');
                var method = $(this).find('input[name="_method"]').val();

                $.ajax({
                    url: url,
                    dataType: 'json',
                    contentType: 'application/json',
                    method: $(this).attr('method'),
                    data: JSON.stringify({
                        id: id,
                        _token: token,
                        _method: method
                    }),
                    success: function(response) {
                        if(response.success) {
                            console.log('ok');
                            $('#dialog-delete').modal('toggle');
                            $('#content-cart').html(response.data);
                            $('#count-cart-items').html(response.count);
                            countTotalPrice();
                        }
                    },
                    error: function(err) {
                    }
                });
            })
        })
    </script>
@endsection
