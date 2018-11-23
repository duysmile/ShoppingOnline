@extends('layout_admin.master')
@section('content')
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="#">Products</a>
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
        <a href="{{route('products.create')}}" class="btn btn-primary">
            Thêm sản phẩm
        </a>
    </div>

    <!-- DataTables Example -->
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-table"></i>
            Data Table Example</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                        <th>Phân loại</th>
                        <th>Ngày nhập</th>
                        <th>Thao tác</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                        <th>Phân loại</th>
                        <th>Ngày nhập</th>
                        <th>Thao tác</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <tr>
                        <td>Dell Inspiron</td>
                        <td>12</td>
                        <td>1000000</td>
                        <td>Laptop</td>
                        <td>2011/04/25</td>
                        <td>
                            <a href="" class="btn btn-success">
                                <i class="fa fa-edit text-white"></i>
                            </a>
                            <a href="" class="btn btn-danger" data-toggle="modal" data-target="#dialog-del">
                                <i class="fa fa-trash text-white"></i>
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
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
                    Bạn có chắc chắn muốn xóa?
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Không</button>
                    <button type="button" class="btn btn-success" data-dismiss="modal">Có</button>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{asset('js/admin/chart-area-demo.js')}}"></script>
@endsection
