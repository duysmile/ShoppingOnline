@extends('layout_admin.master')
@section('content')
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="#">{{__('Categories')}}</a>
        </li>
        <li class="breadcrumb-item active">{{__('Add')}}</li>
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
        <form action="{{route('categories.store')}}" method="post" class="w-100">
            @csrf
            <div class="form-group">
                <label for="">{{_('Tên danh mục')}}</label>
                <input required type="text" value="{{old('name')}}" class="form-control" name="name">
            </div>
            <div class="form-group">
                <label for="">{{__('Phân cấp danh mục')}}</label>
                <select required name="is_parent" class="form-control">
                    <option disabled selected hidden>{{__('Lựa chọn phân cấp')}}</option>
                    <option value="parent">{{__('Danh mục cha')}}</option>
                    <option value="child"
                        @if($parentCategories->count() == 0)
                            disabled
                        @endif
                    >{{__('Danh mục con')}}</option>
                </select>
            </div>
            @if($parentCategories->count() > 0)
            <div id="parentCate" class="collapse form-group">
                <label for="">{{__('Lựa chọn danh mục cha')}}</label>
                <select required name="parent_id" class="form-control">
                    <option hidden disabled selected>{{__('Lựa chọn danh mục cha')}}</option>
                    @foreach($parentCategories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
            @endif
            <div class="form-group">
                <label class="custom-checkbox">
                    <input type="radio" value="true" name="top">
                    <div class="checkbox-box"></div>
                    <div style="clear: both"></div>
                </label>
                <label class="ml-4">{{__('Hiển thị top')}}</label>
            </div>
            <div class="form-group">
                <button class="btn btn-default">
                    {{__('Trở lại')}}
                </button>
                <input value="{{__('Lưu')}}" type="submit" class="btn btn-primary">
            </div>
        </form>
    </div>

@endsection

@section('js')
    <script>
        @if($parentCategories->count() > 0)
        $(document).ready(function () {
            $(document).on('change', 'select[name="is_parent"]', function () {
                var selection = $(this).val();
                console.log(selection)
                if (selection == 'child') {
                    $('#parentCate').collapse('show');
                    $('select[name="parent_id"]').prop('required', true);
                } else {
                    $('#parentCate').collapse('hide');
                    $('select[name="parent_id"]').prop('required', false);
                }
            })
        });
        @endif
    </script>
@endsection
