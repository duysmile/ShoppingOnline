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
        $(document).ready(function () {
            /**
             * handle check item in cart
             */

            // list item is checked
            var listItems = [];
            // list item in cart
            var listProducts = [];

            var items = $('input[name="items"]');
            var amount = $('input[name="amount"]');

            /**
             *  load data from localstorage to listItems
             */
            function loadItem() {
                if (localStorage.getItem('listItems') !== null) {
                    listItems = JSON.parse(localStorage.getItem('listItems'));
                }

                listItems.forEach(function (item) {
                    $('input[type="checkbox"][data-id="' + item.id + '"]').prop('checked', true);
                });

                if (isCheckedAll()) {
                    $('input[type="checkbox"][name="check-all"]').prop('checked', true);
                };

                countTotalPrice();
            }

            /**
             * check if all checkbox is checked
             */
            function isCheckedAll() {
                listProducts = [];
                $('input[type="checkbox"][data-id]').each(function (input, item) {
                    listProducts.push($(item).attr('data-id'));
                });

                return listProducts.every(function (item) {
                    return $('input[type="checkbox"][data-id="' + item + '"]').is(':checked');
                });
            }

            /**
             * get id of all checked checkbox
             */
            $(document).on('change', 'input[type="checkbox"][data-id]', function (e) {
                var checked = $(this).is(':checked');
                var id = $(this).attr('data-id');
                var qty = $('input[type="number"][data-items="' + id + '"]').val();
                var index = listItems.map(function(item){
                    return item.id;
                }).indexOf(id);

                if (checked && index < 0) {
                    listItems.push({id: id, qty: qty});
                    localStorage.setItem('listItems', JSON.stringify(listItems));
                } else if (!checked && index >= 0) {
                    listItems.splice(index, 1);
                    localStorage.setItem('listItems', JSON.stringify(listItems));
                }
                if (isCheckedAll()) {
                    $('input[name="check-all"]').prop('checked', true);
                } else {
                    $('input[name="check-all"]').prop('checked', false);
                }
                countTotalPrice();
            })

            /**
             * check all checkbox when click select all
             */
            $(document).on('change', 'input[name="check-all"]', function (e) {
                var checked = $(this).is(':checked');

                if (checked) {
                    var list = listProducts.map(function(item) {
                        var id = item;
                        var qty = $('input[type="number"][data-items="' + id + '"]').val();
                        return {id: id, qty: qty};
                    })
                    listItems = list;
                    $('input[type="checkbox"]').prop('checked', true);
                    localStorage.setItem('listItems', JSON.stringify(list));
                } else {
                    $('input[type="checkbox"]').prop('checked', false);
                    localStorage.setItem('listItems', '[]');
                    listItems = [];
                }
                countTotalPrice();
            });

            /**
             * count price of all product
             */
            function countTotalPrice() {
                var totalPrice = 0;
                listItems.forEach(function (item) {
                    var price = $('.price-products[data-id="' + item.id + '"]').attr('data-price');
                    totalPrice += parseFloat(price);
                })

                if (totalPrice != 0) {
                    $('.totalPrice').html(money(totalPrice + '000'));
                } else {
                    $('.totalPrice').html(money(totalPrice));
                }

                var count = 0;
                listItems.forEach(function(item) {
                    count += parseInt(item.qty);
                });

                $('#count-items').text(count);
                items.val(JSON.stringify(listItems));
                amount.val(JSON.stringify(totalPrice));
            }

            /**
             * update price when change quantity
             */
            $(document).on('input', 'input[data-items]', function () {
                var id = $(this).attr('data-items');
                var price = $('span[data-id="' + id + '"][data-price-one]').attr('data-price-one');
                var qty = $(this).val();
                if (qty <= 0) {
                    $(this).val(1);
                    return;
                }
                var total = Number(price) * qty;

                listItems = listItems.map(function (item) {
                    if (item.id == id) {
                        item.qty = qty;
                    }
                    return item;
                });

                localStorage.setItem('listItems', JSON.stringify(listItems));

                $('span[data-id="' + id + '"][data-price]').text(money(total + '000'));
                $('span[data-id="' + id + '"][data-price]').attr('data-price', total);
                countTotalPrice();
            });

            /**
             * update quantity cart on server
             */
            $(document).on('change', 'input[data-items]', function () {
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
                    success: function (response) {
                    },
                    error: function (err) {
                    }
                });
            });

            /**
             * show delete dialog to delete a item in cart
             */
            $(document).on('click', 'a.delete-item-card', function (e) {
                var id = $(this).attr('data-id');
                $('#dialog-delete input[name="id"]').val(id);
            });

            /**
             * delete cart dialog
             */
            $(document).on('submit', '#dialog-delete form', function (e) {
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
                    success: function (response) {
                        if (response.success) {
                            $('#dialog-delete').modal('toggle');
                            $('#content-cart').html(response.data);
                            $('#count-cart-items').html(response.count);
                            countTotalPrice();
                        }
                    },
                    error: function (err) {
                    }
                });
            });

            //init
            countTotalPrice();
            loadItem();
        })
    </script>
@endsection
