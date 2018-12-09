@extends('layout_user.master')
@section('content')
    <div class="container d-flex flex-column justify-content-center my-3" style="min-height: 38.2vh;">
        <div class="w-100">
            <span class="w-100 d-block alert alert-danger rounded-0">
                {{$message}}
            </span>
        </div>
        <div class="d-flex justify-content-center">
            <a href="{{route('cart')}}" class="btn btn-common bg-common text-white">
                {{__('Trở lại')}}
            </a>
        </div>
    </div>
@endsection
