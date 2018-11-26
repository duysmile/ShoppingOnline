@extends('layout_admin.master')
@section('content')
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="#">Products</a>
        </li>
        <li class="breadcrumb-item active">Detail</li>
    </ol>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div><br/>
    @endif
    @if($message = Session::get('error'))
        <div class="row pt-2 px-3">
            <div class="alert alert-danger col-12">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                {{$message}}
            </div>
        </div>
    @endif

    <div class="d-flex">
        <a href="{{route('products.index')}}" class="btn btn-primary mb-3">
            {{__('Trở lại')}}
        </a>
        <a href="{{route('products.edit', $product->id)}}" class="btn btn-success mb-3 ml-2">
            {{__('Chỉnh sửa')}}
        </a>
    </div>

    <div class="pb-3">
        <div class="d-flex">
            <div class="w-100 border bg-white d-flex p-3">
                <div class="w-50 p-3">
                    <img class="img-fluid" src="{{asset($product->images[0]->url)}}" alt="">
                </div>
                <div class="w-50">
                    <div class="d-flex align-items-center">
                        @if($product->star > 4)
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
                        @for ($i = 0; $i < $product->star; $i++)
                        <i class="fa fa-star color-common mr-1"></i>
                        @endfor
                    </span>
                    <p class="text-justify">
                        {{$product->summary}}
                    </p>
                    <p>
                        <span class="bg-light d-block p-3 text-common mb-3">
                            <u>{{__('đ')}}</u> {{money($product->price . '000')}}
                        </span>
                    </p>
                    <form class="form-inline w-100">
                        <div class="input-group mb-2">
                            <label class="mr-3">
                                {{__('Số lượng')}}
                            </label>
                            <input type="number" class="form-control" value="1" max="{{$product->quantity}}">
                        </div>
                        <div class="form-group pt-3">
                            <button class="btn mr-3 bg-white border-common color-common">
                                {{__('Thêm vào giỏ hàng')}}
                            </button>
                            <button class="btn mr-3 b-color-common border-common text-white">
                                {{__('Mua ngay')}}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex border flex-column p-3 bg-white">
        <h4 class="border-bottom pb-3">
            {{__('CHI TIẾT SẢN PHẨM')}}
        </h4>
        <div class="w-100 bg-white p-3">
            {!! $product->description !!}
        </div>
    </div>

@endsection

@section('js')

@endsection
