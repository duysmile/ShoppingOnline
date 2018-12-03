<section id="cart" class="container my-3">
    <div class="b-color-common p-3">
        <h4 class="text-white ml-3">
            {{__('GIỎ HÀNG')}}
        </h4>
    </div>
    <div class="d-flex flex-column">
        <div class="d-flex justify-content-between item-card-header">
            <div class="h-100 d-flex align-items-center w-50">
                <label class="custom-checkbox">
                    <input type="checkbox">
                    <div class="checkbox-box"></div>
                </label>
                <div class="h-100 d-flex ml-4 align-items-center">
                    {{__('Sản phẩm')}}
                </div>
            </div>
            <div class="d-flex align-items-center w-50">
                <p class="w-25">
                    {{__('Đơn giá')}}
                </p>
                <p class="w-25">
                    {{__('Số lượng')}}
                </p>
                <p class="w-25">
                    {{__('Số tiền')}}
                </p>
                <p class="w-25">
                    {{__('Thao tác')}}
                </p>
            </div>
        </div>
        @foreach($cart->items as $product)
        <div class="d-flex justify-content-between item-card">
            <div class="h-100 d-flex align-items-center w-50">
                <label class="custom-checkbox">
                    <input type="checkbox">
                    <div class="checkbox-box"></div>
                </label>
                <div class="h-100 d-flex ml-5">
                    <img class="cart-img h-100 mr-3" src="{{$product->images[0]->url}}" alt="">
                    <p>
                        {{$product->name}}
                    </p>
                </div>
            </div>
            <div class="d-flex align-items-center w-50">
                <p class="w-25">
                    <u>{{__('đ')}}</u>
                    <span data-price-one="{{$product->price}}" data-id="{{$product->id}}">
                        {{money($product->price . '000')}}
                    </span>
                </p>
                <input type="number" class="form-control w-25" data-items="{{$product->id}}" min="1" value="{{$product->pivot->quantity}}">
                <p class="w-25 color-common">
                    <u>{{__('đ')}}</u>
                    <span class=" price-products" data-price="{{$product->pivot->quantity * $product->price}}" data-id="{{$product->id}}">
                        {{money(($product->pivot->quantity * $product->price) . '000')}}
                    </span>
                </p>
                <div class="w-25 text-center">
                    <a href="">{{__('Xóa')}}</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

<section id="cart" class="container my-3">
    <div class="d-flex justify-content-between item-card">
        <div class="h-100 d-flex align-items-center w-50">
            <label class="custom-checkbox">
                <input type="checkbox">
                <div class="checkbox-box"></div>
            </label>
            <div class="h-100 d-flex ml-5 align-items-center">
                {{__('Chọn tất cả')}}
            </div>
        </div>
        <div class="d-flex align-items-center w-50">
            <p>
                {{__('Tổng số tiền (' . $cart->items()->count() . ' sản phẩm)')}}
            </p>
            <p class="w-50 size-larger color-common text-right mr-3">
                <u>đ</u>
                <span class="totalPrice">

                </span>
            </p>
            <div class="w-25 text-center mr-3">
                <a href="" class="btn b-color-common text-white">{{__('Mua ngay')}}</a>
            </div>
        </div>
    </div>
</section>
