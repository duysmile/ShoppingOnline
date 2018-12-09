<div class="d-flex flex-column">
    @foreach($invoices as $invoice)
        <div class="mt-3 bg-common text-white p-3">
            <a class="text-white" href="" data-toggle="collapse"
               data-target="{{'#invoice' . $invoice->id}}">
                {{__('Thời gian đặt: ') . date('d-m-Y', $invoice->created_at->timestamp)}}
            </a>
        </div>

        <div class="collapse" id="{{'invoice' . $invoice->id}}">

            <div class="d-flex justify-content-between mt-1 item-card-header-pr">
                <div class="h-100 d-flex align-items-center w-50">
                    <div class="h-100 d-flex ml-4 align-items-center">
                        {{__('Sản phẩm')}}
                    </div>
                </div>
                <div class="d-flex align-items-center w-50 justify-content-end">
                    <p class="w-25">
                        {{__('Đơn giá')}}
                    </p>
                    <p class="w-25">
                        {{__('Số lượng')}}
                    </p>
                    <p class="w-25">
                        {{__('Số tiền')}}
                    </p>
                </div>
            </div>
            @foreach($invoice->items as $item)
                <div class="d-flex justify-content-between item-card-pr">
                    <div
                        class="h-100 d-flex align-items-center w-50 justify-content-start py-2">
                        <div class="h-100 d-flex">
                            <img class="cart-img h-100 mr-3"
                                 src="{{$item->product->images[0]->url}}"
                                 alt="">
                            <p>
                                {{$item->product->name}}
                            </p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center w-50 justify-content-end">
                        <p class="w-25">
                            <u>đ</u>{{money($item->product->price . '000')}}
                        </p>
                        <p class="w-25 text-center">1</p>
                        <p class="w-25">
                            <u>đ</u>{{money(($item->product->price * $item->quantity) . '000')}}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-end item-card-pr">
            <div class="d-flex align-items-center w-50">
                <p>
                    {{__('Tổng số tiền (' . $invoice->totalItems . ' sản phẩm)')}}
                </p>
                <p class="w-50 size-larger color-common text-right mr-3">
                    <u>đ</u>{{money($invoice->amount . '000')}}
                </p>
            </div>
        </div>
    @endforeach
</div>
