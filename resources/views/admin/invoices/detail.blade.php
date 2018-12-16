@extends('layout_admin.master')
@section('head-meta')
    <meta name="csrf" content="{{csrf_token()}}">
@endsection
@section('style')
    <link rel="stylesheet" href="{{asset('css/admin/app.css')}}">
@endsection
@section('content')
    <div class="d-flex">
        <a class="btn btn-primary rounded-0" href="{{ URL::previous() }}">
            {{__('Trở lại')}}
        </a>
        @if ($invoice->status == constants('CART.STATUS.PENDING'))
        <form action="{{route('invoices.update-status-detail', $invoice->id)}}" method="post">
            @csrf
            <input type="hidden" name="_method" value="patch">
            <input type="hidden" name="type" value="invoice">
            <input type="hidden" name="id" value="{{$invoice->id}}">
            <button type="submit" class="btn btn-success rounded-0">
                {{__('Duyệt đơn hàng')}}
            </button>
        </form>
        @endif
    </div>
    <div class="d-flex justify-content-between mt-1 bg-common py-2 text-white">
        <div class="h-100 d-flex align-items-center w-50">
            <div class="h-100 d-flex ml-4 align-items-center">
                {{__('Sản phẩm')}}
            </div>
        </div>
        <div class="d-flex align-items-center w-50 justify-content-end h-100">
            <span class="w-25">
                {{__('Đơn giá')}}
            </span>
            <span class="w-25">
                {{__('Số lượng')}}
            </span>
            <span class="w-25">
                {{__('Số tiền')}}
            </span>
        </div>
    </div>
    @foreach($invoice->items as $item)
        <div class="d-flex justify-content-between border-bottom">
            <div
                class="h-100 d-flex align-items-center w-50 justify-content-start py-2">
                <div class="h-100 d-flex">
                    <img class="h-100 mr-3 invoice-img"
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
    <div class="d-flex justify-content-end">
        <div class="d-flex align-items-center justify-content-end w-50 pt-4 mr-4">
            <p>
                {{__('Tổng số tiền (' . $invoice->totalItems . ' sản phẩm)')}}
            </p>
            <p class="w-25 color-common text-right mr-5 font-weight-bold">
                <u>đ</u>{{money($invoice->amount . '000')}}
            </p>
        </div>
    </div>
@endsection
