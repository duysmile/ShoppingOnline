<section id="categories" class="container px-0">
    @foreach($categories as $category)
        <div class="mt-4 mb-5 pb-5 border-bottom">
            <div class="header-category d-flex align-items-center">
                <h2 class="text-uppercase">
                    {{$category->name}}
                </h2>
                <span class="custom-line-category"></span>
            </div>
            <div class="d-flex mt-2 box-category">
                <div class="left-box-category">
                    <a href="{{route('detail-product', $category->products[0]->slug)}}">
                        <h2>
                            {{$category->products[0]->name}}
                        </h2>
                        <img src="{{$category->products[0]->images[0]->url}}" alt="">
                    </a>
                </div>

                <div class="d-flex flex-column right-box-category">
                    @foreach($category->products->slice(1,6)->chunk(3) as $key => $products)
                        <div class="d-flex h-50
                        @if ($key == 0)
                            border-bottom
                        @endif">
                            @foreach($products as $product)
                                <div class="right-box-item">
                                    <a href="{{route('detail-product', $product->slug)}}">
                                        <h2>
                                            {{$product->name}}
                                        </h2>
                                        <div class="d-flex justify-content-end align-items-center h-75 mr-4">
                                            <img src="{{$product->images[0]->url}}" alt="">
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
</section>
