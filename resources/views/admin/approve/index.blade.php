@extends('layout_admin.master')
@section('head-meta')
    <meta name="csrf" content="{{csrf_token()}}">
@endsection
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

    <div id="success_alert" class="row pt-2 px-3">
        <div class="alert alert-success col-12">
            <button type="button" class="close success">&times;</button>
            <span data-bind="success"></span>
        </div>
    </div>

    <div id="error_alert" class="row pt-2 px-3">
        <div class="alert alert-danger col-12">
            <button type="button" class="close error">&times;</button>
            <span data-bind="error"></span>
        </div>
    </div>

    <!-- DataTables Example -->
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-table"></i>
            {{__('Danh sách sản phẩm chưa phê duyệt')}}
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>{{__('STT')}}</th>
                        <th>{{__('Sản phẩm')}}</th>
                        <th>{{__('Số lượng')}}</th>
                        <th>{{__('Đơn giá(VNĐ)')}}</th>
                        <th>{{__('Phân loại')}}</th>
                        <th>{{__('Ngày nhập')}}</th>
                        <th>{{__('Người tạo')}}</th>
                        <th>{{__('Thao tác')}}</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>{{__('STT')}}</th>
                        <th>{{__('Sản phẩm')}}</th>
                        <th>{{__('Số lượng')}}</th>
                        <th>{{__('Đơn giá(VNĐ)')}}</th>
                        <th>{{__('Phân loại')}}</th>
                        <th>{{__('Ngày nhập')}}</th>
                        <th>{{__('Người tạo')}}</th>
                        <th>{{__('Thao tác')}}</th>
                    </tr>
                    </tfoot>
                    <tbody id="data-table">
                    @foreach($products as $product)
                        <tr>
                            <td>{{$loop->index + 1}}</td>
                            <td>{{$product->name}}</td>
                            <td>{{$product->quantity}}</td>
                            <td>{{money($product->price . '000')}}</td>
                            <td>{{$product->categories[0]->name}}</td>
                            <td>{{$product->created_at}}</td>
                            <td>{{$product->author->name}}</td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{route('approve.update')}}" data-approve="product" data-id="{{$product->id}}" class="btn btn-success rounded-0">
                                        <i class="fa fa-check text-white"></i>
                                    </a>
                                    <a href="" data-id="{{$product->id}}" class="btn btn-del btn-danger rounded-0" data-toggle="modal"
                                       data-target="#dialog-del">
                                        <i class="fa fa-trash text-white"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="d-flex justify-content-center pb-4">
            {{$products->links()}}
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
                    <form action="{{route('products.destroy', -1)}}" method="post">
                        @csrf
                        <input type="hidden" value="delete" name="_method">
                        <input type="hidden" value="approve" name="type">
                        <input type="hidden" value="" name="del-id">
                        <input type="submit" class="btn btn-success" value="{{__('Có')}}">
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#error_alert').hide();
            $('#success_alert').hide();
            $(document).on('click', 'button.close.error', function () {
                $('#error_alert').hide();
            });
            $(document).on('click', 'button.close.success', function () {
                $('#success_alert').hide();
            });
            $(document).on('click', 'a[data-approve]', function (e) {
                e.preventDefault();
                var url = $(this).attr('href');
                var id = $(this).attr('data-id');
                var type = $(this).attr('data-approve');
                var CSRF_TOKEN = $('meta[name="csrf"]').attr('content');

                $.ajax({
                    method: 'post',
                    url: url,
                    contentType: 'application/json',
                    dataType: 'json',
                    data: JSON.stringify({
                        id: id,
                        type: type,
                        _token: CSRF_TOKEN,
                        _method: 'PATCH'
                    }),
                    success: function (response) {
                        $('#error_alert').hide();
                        $('#success_alert').show();
                        $('#success_alert span[data-bind="success"]').text(response.message);
                        var tmp_data = '';
                        response.data.forEach(function(item, index) {
                            var template = '<tr>' +
                                '    <td>:index</td>' +
                                '    <td>:name</td>' +
                                '    <td>:quantity</td>' +
                                '    <td>:price</td>' +
                                '    <td>:category</td>' +
                                '    <td>:created_at</td>' +
                                '    <td>:author</td>' +
                                '    <td>' +
                                '       <div class="d-flex">' +
                                '        <a href=":url" data-approve="product" data-id=":id" class="btn btn-success rounded-0">' +
                                '            <i class="fa fa-check text-white"></i>' +
                                '        </a>' +
                                '        <a href="" data-id=":id" class="btn btn-del btn-danger rounded-0" data-toggle="modal"' +
                                '           data-target="#dialog-del">' +
                                '            <i class="fa fa-trash text-white"></i>' +
                                '        </a>' +
                                '       </div>'
                                '    </td>' +
                                '</tr>'
                            template = template.replace(':index', index + 1);
                            template = template.replace(':id', item.id);
                            template = template.replace(':id', item.id);
                            template = template.replace(':name', item.name);
                            template = template.replace(':quantity', item.quantity);
                            template = template.replace(':price', item.price);
                            template = template.replace(':category', item.category);
                            template = template.replace(':created_at', item.created_at.date.substr(0, 10));
                            template = template.replace(':author', item.author);
                            template = template.replace(':url', url);
                            tmp_data += template;
                        });
                        $('#data-table').html(tmp_data);
                    },
                    error: function (err) {
                        $('#error_alert').show();
                        $('#success_alert').hide();
                        $('#error_alert span[data-bind="error"]').text(err.responseJSON.message);
                    }
                })
            })
        })
    </script>

    <script src="{{asset('js/admin/delete-dialog.js')}}"></script>
@endsection
