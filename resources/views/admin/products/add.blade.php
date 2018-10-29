@extends('layout_admin.master')
@section('content')
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="#">Products</a>
        </li>
        <li class="breadcrumb-item active">Add</li>
    </ol>

    <div class="d-flex mb-3">
        <form action="" class="w-100">
            <div class="form-group">
                <label for="">Tên sản phẩm</label>
                <input type="text" class="form-control">
            </div>
            <div class="form-group">
                <label for="">Mô tả</label>
                <input type="text" class="form-control">
            </div>
            <div class="form-group">
                <label for="">Số lượng</label>
                <input type="number" class="form-control">
            </div>
            <div class="form-group">
                <label for="">
                    Phân loại
                </label>
                <div class="form-check">
                    <input data-type="parent"
                           type="checkbox" class="form-check-input" name="category" >
                    <label class="form-check-label" for="exampleCheck1">Laptop</label>
                    <span data-toggle="collapse" data-target="#category1">
                        &nbsp;<i class="fa fa-chevron-down"></i>
                    </span>
                </div>
                <div class="collapse" id="category1">
                    <div class="ml-3 form-check">
                        <input data-type="child"
                               type="checkbox" class="form-check-input" name="category">
                        <label class="form-check-label">Dell</label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="">Chi tiết sản phẩm</label>
                <textarea id="mytextarea">Hello, World!</textarea>
            </div>
            <div class="form-group">
                <button class="btn btn-default">
                    Trở lại
                </button>
                <button class="btn btn-primary">
                    Lưu
                </button>
            </div>
        </form>
    </div>

@endsection

@section('js')
    <script src='https://cloud.tinymce.com/stable/tinymce.min.js'></script>
    <script>
        tinymce.init({
            selector: '#mytextarea'
        });
    </script>
    <script src="{{asset('js/admin/create-products.js')}}"></script>
@endsection
