@extends('layout_admin.master')
@section('content')
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="#">Users</a>
        </li>
        <li class="breadcrumb-item active">List</li>
    </ol>

    @if($message = Session::get('success'))
        <div class="row pt-2 px-3">
            <div class="alert alert-success col-12">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                {{$message}}
            </div>
        </div>
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
        <a href="{{route('users.create')}}" class="btn btn-primary">
            {{__('Thêm người dùng')}}
        </a>
    </div>

    <!-- DataTables Example -->
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-table"></i>
            {{__('Danh sách người dùng')}}
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>{{__('STT')}}</th>
                        <th>{{__('Tên tài khoản')}}</th>
                        <th>{{__('Tên người dùng')}}</th>
                        <th>{{__('Vai trò')}}</th>
                        <th>{{__('Tình trạng')}}</th>
                        <th>{{__('Người tạo')}}</th>
                        <th>{{__('Thao tác')}}</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>{{__('STT')}}</th>
                        <th>{{__('Tên tài khoản')}}</th>
                        <th>{{__('Tên người dùng')}}</th>
                        <th>{{__('Vai trò')}}</th>
                        <th>{{__('Tình trạng')}}</th>
                        <th>{{__('Ngày tạo')}}</th>
                        <th>{{__('Thao tác')}}</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{$loop->index + 1}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->info == null ? "" : $user->info->name}}</td>
                            <td>
                                @foreach($user->roles as $role)
                                    {{$role->name}}
                                @endforeach
                            </td>
                            <td>{{$user->is_blocked ? "Locked" : "Active"}}</td>
                            <td>{{$user->created_at}}</td>
                            <td class="d-flex justify-content-between">
                                {{--<a href="{{route('users.show', $user->id)}}" class="btn btn-primary rounded-0">--}}
                                    {{--<i class="fa fa-eye text-white"></i>--}}
                                {{--</a>--}}
                                <a href="" data-id="{{$user->id}}" class="btn btn-del btn-danger rounded-0" data-toggle="modal"
                                   data-target="#dialog-del">
                                    <i class="fa fa-lock text-white"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="d-flex justify-content-center pb-4">
            {{$users->links()}}
        </div>
        <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
    </div>
    <div class="modal" id="dialog-del">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Thông báo</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    Bạn có chắc chắn muốn khóa?
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Không</button>
                    <form action="{{route('users.destroy', -1)}}" method="post">
                        @csrf
                        <input type="hidden" value="delete" name="_method">
                        <input type="hidden" value="" name="del-id">
                        <input type="submit" class="btn btn-success" value="{{__('Có')}}">
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{asset('js/admin/delete-dialog.js')}}"></script>
@endsection
