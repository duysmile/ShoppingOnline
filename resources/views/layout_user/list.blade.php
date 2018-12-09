<section id="list" class="container my-3">
    <div class="b-color-common p-3">
        <h4 class="text-white ml-3 text-uppercase">
            {{$category->name}}
        </h4>
    </div>
    @foreach($listProducts->chunk(5) as $products)
        <div class="d-flex pt-2 list-products">
            @foreach($products as $key => $product)
                <div class="w-20 py-2
                    @if(($key + 1) % 5 != 0)
                        pr-2
                    @endif">
                    <a class="product-disp" href="{{route('detail-product', $product->slug)}}">
                        <div class="border p-3 bg-white w-100">
                            <img class="img-fluid product-img-list" src="{{$product->images[0]->url}}" alt="">
                            <p class="text-justify pt-2 text-truncate">
                                <b>{{$product->name}}</b>
                            </p>
                            <p class="text-justify summary-product text-truncate">
                                {{$product->summary}}
                            </p>
                            <p>
                                <span class="mr-1"><s><u>{{__('đ')}}</u>&nbsp;{{money($product->standard_price . '000')}} </s></span>
                                <span class="color-common"><u>{{__('đ')}}</u>&nbsp;{{money($product->price . '000')}} </span>
                            </p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @endforeach
    <div class="d-flex justify-content-center mt-2">
        {{$listProducts->links()}}
    </div>
</section>
