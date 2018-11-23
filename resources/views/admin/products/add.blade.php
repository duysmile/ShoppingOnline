@extends('layout_admin.master')
@section('content')
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="#">Products</a>
        </li>
        <li class="breadcrumb-item active">Add</li>
    </ol>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div><br />
    @endif
    @if($message = Session::get('error'))
        <div class="row pt-2 px-3">
            <div class="alert alert-danger col-12">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                {{$message}}
            </div>
        </div>
    @endif

    <div class="d-flex mb-3">
        <form action="{{route('products.store')}}" method="post" class="w-100" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="">{{__('Tên sản phẩm')}}</label>
                <input type="text" name="product_name" value="{{old('product_name')}}" class="form-control">
            </div>
            <div class="form-group">
                <label for="">{{__('Mô tả')}}</label>
                <input type="text" name="sum" value="{{old('sum')}}" class="form-control">
            </div>
            <div class="d-flex">
                <div class="form-group mr-2">
                    <label for="">{{__('Số lượng')}}</label>
                    <input type="number" name="qty" value="{{old('qty')}}" class="form-control">
                </div>
                <div class="form-group">
                    <label class="d-block">{{__('Giá sản phẩm')}}</label>
                    <input type="number" name="price" value="{{old('price')}}" class="form-control d-inline-block"> .000
                </div>
                </div>
            <div class="form-group">
                <label for="">
                    {{_('Phân loại')}}
                </label>
                <div class="form-check">
                    <input data-type="parent"
                           type="checkbox" class="form-check-input" name="categories">
                    <label class="form-check-label" for="exampleCheck1">Laptop</label>
                    <span data-toggle="collapse" data-target="#category1">
                        &nbsp;<i class="fa fa-chevron-down"></i>
                    </span>
                </div>
                <div class="collapse" id="category1">
                    <div class="ml-3 form-check">
                        <input data-type="child"
                               type="checkbox" class="form-check-input" name="categories">
                        <label class="form-check-label">Dell</label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="">Chi tiết sản phẩm</label>
                <textarea id="content" name="content">{{old('content')}}</textarea>
            </div>
            <div class="form-group">
                <label>{{__('Ảnh sản phẩm')}}</label>
                <input type="file" name="images">
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
    <script src='{{asset('js/node_modules/tinymce/tinymce.min.js')}}'></script>
    <script type="text/javascript">
        var editor_config = {
            path_absolute: "/",
            selector: "#content",
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor colorpicker textpattern"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
            relative_urls: false,
            file_browser_callback: function (field_name, url, type, win) {
                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                var y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;
                var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
                if (type == 'image') {
                    cmsURL = cmsURL + "&type=Images";
                } else {
                    cmsURL = cmsURL + "&type=Files";
                }
                tinyMCE.activeEditor.windowManager.open({
                    file: cmsURL,
                    title: 'Filemanager',
                    width: x * 0.8,
                    height: y * 0.8,
                    resizable: "yes",
                    close_previous: "no"
                });
            }
        };
        tinymce.init(editor_config);
    </script>
    <script src="{{asset('js/admin/create-products.js')}}"></script>
@endsection
