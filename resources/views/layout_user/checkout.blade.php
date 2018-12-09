<section id="cart" class="container my-3">
    <div class="d-flex flex-column">
        <div class="d-flex flex-column item-card justify-content-center">
            <h5 class="px-4 py-2 color-common font-weight-normal m-0">
                <i class=" fa fa-map-marker-alt"></i>
                {{__('Địa chỉ nhận hàng')}}
            </h5>
            <div class="px-4 py-2 d-flex align-items-center font-size-lg">
                <span class="text-nowrap">
                    <b>{{Auth::user()->info->name}}</b>
                </span>
                &nbsp;
                <span class="text-nowrap">
                    <b>{{Auth::user()->info->tel_no}}</b>
                </span>
                <span class="ml-4 address font-size-md" style="max-width: 450px">
                    {{Auth::user()->info->address}}
                </span>
                <span class="badge badge-secondary text-white rounded-0 ml-3">
                    {{__('Mặc định')}}
                </span>
                <a class="ml-5 text-primary" href="javascript:void(0)" data-target="#change-info-dialog" data-toggle="modal">
                    {{__('THAY ĐỔI')}}
                </a>
            </div>
        </div>
        <div class="d-flex justify-content-between item-card-header">
            <div class="h-100 d-flex align-items-center w-50">
                <div class="h-100 d-flex ml-5 align-items-center">
                    {{__('Sản phẩm')}}
                </div>
            </div>
            <div class="d-flex align-items-center w-50">
                <p class="w-25"></p>
                <p class="w-25">
                    {{__('Đơn giá')}}
                </p>
                <p class="w-25">
                    {{__('Số lượng')}}
                </p>
                <p class="w-25">
                    {{__('Thành tiền')}}
                </p>
            </div>
        </div>
        @foreach($products as $product)
            <div class="d-flex justify-content-between item-card">
                <div class="h-100 d-flex align-items-center w-50">
                    <div class="h-100 d-flex ml-5">
                        <img class="cart-img h-100 mr-3" src="{{$product->images[0]->url}}" alt="">
                        <p>
                            {{$product->name}}
                        </p>
                    </div>
                </div>
                <div class="d-flex align-items-center w-50">
                    <p class="w-25"></p>
                    <p class="w-25">
                        <u>{{__('đ')}}</u>
                        <span data-price-one="{{$product->price}}" data-id="{{$product->id}}">
                        {{money($product->price . '000')}}
                    </span>
                    </p>
                    <span class="w-25 text-center" data-items="{{$product->id}}"
                          min="1"> {{$product->quantity}}
                    </span>
                    <p class="w-25 color-common">
                        <u>{{__('đ')}}</u>
                        <span class=" price-products"
                              data-price="{{$product->quantity * $product->price}}"
                              data-id="{{$product->id}}"
                        >
                            {{money(($product->quantity * $product->price) . '000')}}
                        </span>
                    </p>
                </div>
            </div>
        @endforeach
    </div>
</section>

<section id="cart" class="container my-3">
    <div class="d-flex justify-content-end item-card">
        <div class="d-flex justify-content-end align-items-center w-50">
            <p class="w-auto text-nowrap mr-5">
                {{__('Tổng số tiền')}}
            </p>
            <p class="w-auto size-larger color-common text-right mr-3">
                <u>đ</u>
                <span class="totalPrice">
                    {{money($amount . '000')}}
                </span>
            </p>
            <div class="text-center mr-3">
                <form action="{{route('buy-product')}}" method="post">
                    @csrf
                    <input type="hidden" name="address" value="{{Auth::user()->info->address}}" required>
                    <input type="hidden" name="tel_no" value="{{Auth::user()->info->tel_no}}" required>
                    <input type="submit" id="payment" class="btn b-color-common rounded-0 text-white"
                           value="{{__('Đặt hàng')}}"/>
                </form>
            </div>
        </div>
    </div>
</section>
