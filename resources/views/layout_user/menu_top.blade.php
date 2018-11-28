<section class="container mt-4 border bg-white p-3 d-flex" id="menu-top">
    <div class="menu-market">
        <h3>
            <i class="fa fa-list-ul"></i>
            MY MARKETS
        </h3>
        <ul class="menu-top-market">
            @foreach($categories as $category)
                <li class="border-bottom py-2 pl-3">
                    <a href="{{route('list-products', $category->slug)}}">
                        {{$category->name}}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="mx-4 flex-grow-1">
        <div id="menu-top-slider" class="carousel slide custom-carousel" data-ride="carousel">
            <ol class="carousel-indicators custom-indicator">
                <li data-target="#menu-top-slider" data-slide-to="0" class="active"></li>
                <li data-target="#menu-top-slider" data-slide-to="1"></li>
                <li data-target="#menu-top-slider" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                @foreach($topProducts->slice(0, 3) as $key => $product)
                    <div class="carousel-item
                    @if ($key == 0)
                        active
                    @endif ">
                        <img src="{{$product->images[0]->url}}" alt="">
                    </div>
                @endforeach
            </div>
            <a href="#menu-top-slider" class="carousel-control-prev custom-control-slider" role="button"
               data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a href="#menu-top-slider" class="carousel-control-next custom-control-slider" role="button"
               data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
    <div class="menu-popular">
        <a href="" class="d-block text-center bg-primary text-white px-3 py-1 w-100 font-weight-bold">
            Popular Products
        </a>
        <div class="d-flex flex-column w-100 px-3 w-100">
            @foreach($topProducts->slice(3,3) as $product)
            <a href="" class="d-flex flex-column w-100 border-bottom mt-1 pb-1">
                <div class="pb-1 w-75 title-product text-truncate">
                    {{$product->name}}
                </div>
                <div class="d-flex w-100 justify-content-between">
                    <div class="badge badge-primary custom-badge-menu">
                        Buy Now
                    </div>
                    <div>
                        <img class="img-menu-popular" src="{{$product->images[0]->url}}" alt="">
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
