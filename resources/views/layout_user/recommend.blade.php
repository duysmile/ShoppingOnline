<section id="recommend-list" class="container px-0">
    <div class="mt-4 mb-5 pb-5 border-bottom">
        <div class="header-category d-flex align-items-center">
            <h2 style="float:left">
                {{__('RECOMMENDATION FOR YOU')}}
            </h2>
            <span class="custom-line-category"></span>
        </div>
        <div class="d-flex justify-content-between pt-2 list-products">
            @foreach($recommendProducts as $product)
            <div class="w-20 py-2 pr-2 height-recommend">
                <a href="{{route('detail-product', $product->slug)}}">
                    <div class="border p-3 h-100 pb-5">
                        <span class="d-block h-100">
                            <img class="img-fluid img-recommend" src="{{$product->images[0]->url}}" alt="">
                            <p class="text-justify font-weight-bold pt-2">
                                {{$product->name}}
                            </p>
                            <p class="text-justify pt-1">
                                {{$product->summary}}
                            </p>
                        </span>
                        <p class="mb-2">
                        <span class="font-weight-bold color-common">
                            đ{{money($product->price . '000')}}
                        </span>
                        </p>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
