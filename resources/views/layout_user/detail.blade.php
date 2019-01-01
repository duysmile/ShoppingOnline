<section class="container px-0">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light pl-0 ml-0 mb-0">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a
                    href="{{route('list-products', $product->categories[0]->slug)}}">{{$product->categories[0]->name}}</a>
            </li>
        </ol>
    </nav>
    <div class="pb-3">
        <div class="d-flex">
            <div class="w-100 border bg-white d-flex py-3 px-4">
                <div class="mr-3 pr-4 border-right d-flex justify-content-center align-items-center position-relative">
                    <img class="img-fluid detail-product-img" src="{{$product->images[0]->url}}" alt="">
                    @if($product->quantity < 1)
                        <div class="sold-out-img">
                            <div>
                                {{__('Hết hàng')}}
                            </div>
                        </div>
                    @endif
                </div>
                <div class="w-100">
                    <div class="d-flex align-items-center">
                        @if($product->star >= 4)
                            <span class="badge mr-1 font-weight-normal b-color-common text-white text-common-sm">
                                <i class="fa fa-check mr-1"></i>{{__('Yêu thích')}}
                            </span>
                        @endif
                        <h4>
                            {{$product->name}}
                        </h4>
                    </div>
                    <span class="d-block d-flex align-items-center">
                        <u class="color-common text-common-md mr-2">{{$product->star}}</u>
                        @for($index = 0; $index < $product->star; $index ++)
                            <i class="fa fa-star color-common mr-1"></i>
                        @endfor
                    </span>
                    <p class="text-justify">
                        {{$product->summary}}
                    </p>
                    <p class="bg-light p-3 d-flex align-items-center">
                        <span class="mr-2">
                            <s class="text-secondary font-size-md">
                                <u>{{__('đ')}}</u> {{money($product->standard_price . '000')}}
                            </s>
                        </span>
                        <span class="text-common">
                            <u>{{__('đ')}}</u> {{money($product->price . '000')}}
                        </span>
                        <span class="bg-common text-white ml-2 font-super-sm px-1">
                            {{__('Giảm ' . $product->discount . '%')}}
                        </span>
                    </p>
                    <form class="w-100" action="{{route('add-cart')}}" method="post">
                        <div class="mb-2 d-flex align-items-center">
                            <label class="mr-3 mt-1">
                                {{__('Số lượng')}}
                            </label>
                            <input name="qty" type="number" class="form-control d-block" value="1" min="1"
                                   max="{{$product->quantity}}"
                                   @if($product->quantity < 1)
                                       disabled
                                    @endif
                            >
                            <label class="ml-3 mt-1 text-secondary">
                                {{__($product->quantity . ' sản phẩm có sẵn')}}
                            </label>
                        </div>
                        <div>
                            <span data-bind="error" class="text-danger"></span>
                        </div>
                        <div class="form-group pt-3" data-id="{{$product->id}}">
                            @if(Auth::check())
                                <button id="add-cart-button" class="btn mr-3 bg-white border-common color-common"
                                        @if($product->quantity < 1)
                                            disabled
                                        @endif
                                >
                                    {{__('Thêm vào giỏ hàng')}}
                                </button>
                                <button id="buy-button" class="btn mr-3 b-color-common border-common text-white"
                                        @if($product->quantity < 1)
                                            disabled
                                        @endif
                                >
                                    {{__('Mua ngay')}}
                                </button>
                            @else
                                <button href="javascript:void(0)" class="btn mr-3 bg-white border-common color-common"
                                        data-toggle="modal" data-target="#login-register-dialog" data-open="login"
                                >
                                    {{__('Thêm vào giỏ hàng')}}
                                </button>
                                <button id="buy-button" class="btn mr-3 b-color-common border-common text-white"
                                        data-toggle="modal" data-target="#login-register-dialog" data-open="login"
                                        @if($product->quantity == 0)
                                            disabled
                                        @endif
                                >
                                    {{__('Mua ngay')}}
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="container px-0">
    <div class="d-flex border flex-column p-3 bg-white">
        <h4 class="border-bottom pb-3">
            {{__('CHI TIẾT SẢN PHẨM')}}
        </h4>
        <div class="w-100 bg-white p-3">
            {{$product->description}}
        </div>
    </div>
</section>

<section class="container px-0 mt-3">
    <div class="d-flex border flex-column p-3 bg-white">
        <h4 class="border-bottom pb-3">
            {{__('ĐÁNH GIÁ SẢN PHẨM')}}
        </h4>
        <div class="w-100 bg-white p-3">

        </div>
    </div>
</section>
