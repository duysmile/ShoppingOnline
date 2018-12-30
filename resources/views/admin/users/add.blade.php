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

    @if($message = Session::get('success'))
        <div class="row pt-2 px-3">
            <div class="alert alert-success col-12">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                {{$message}}
            </div>
        </div>
    @endif

    <div class="d-flex mb-3">
        <form action="{{route('users.store')}}" method="post" class="w-100">
            @csrf
            <div class="form-group">
                <label for="">{{_('Tên đăng nhập')}}</label>
                <input required type="text" value="{{old('username')}}" class="form-control" name="username">
            </div>
            <div class="form-group">
                <label for="">{{__('Lựa chọn vai trò')}}</label>
                <select required name="role" class="form-control">
                    <option hidden disabled selected>{{__('Lựa chọn vai trò')}}</option>
                    @foreach($roles as $role)
                        <option value="{{$role->slug}}">{{$role->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="">{{_('Email')}}</label>
                <input required type="text" value="{{old('email')}}" class="form-control" name="email">
            </div>
            <div class="form-group">
                <label for="">{{_('Mật khẩu')}}</label>
                <input required type="password" value="{{old('password')}}" class="form-control" name="password">
            </div>
            <div class="form-group">
                <label for="">{{_('Xác nhận mật khẩu')}}</label>
                <input required type="password" value="{{old('password')}}" class="form-control"
                       name="password_confirmation">
            </div>
            <div class="form-group">
                <label for="">{{_('Số điện thoại')}}</label>
                <input required type="text" value="{{old('tel')}}" class="form-control" name="tel">
            </div>
            <div class="form-group">
                <a href="{{ URL::previous() }}" class="btn btn-default bg-light mr-2">
                    {{__('Trở lại')}}
                </a>
                <input value="{{__('Lưu')}}" type="submit" class="btn btn-primary">
            </div>
        </form>
    </div>

@endsection

@section('js')
    <script>
        $(document).ready(function () {
            /**
             * convert tel no when has change
             */
            $(document).on('change', 'input[name="tel"]', function () {
                var tel = $(this).val().trim();

                if (tel[0] == '0') {
                    tel = '(+84)' + tel.slice(1);
                }
                $(this).val(tel);
            });
        });
    </script>
@endsection
