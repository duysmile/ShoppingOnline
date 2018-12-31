<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">{{__('Dashboard')}}</a>
    </li>
    <li class="breadcrumb-item active">{{__('Overview')}}</li>
</ol>

<!-- Icon Cards-->
<div class="row">
    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card text-white bg-primary o-hidden h-100">
            <div class="card-body">
                <div class="card-body-icon">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <div class="mr-5">{{$countNewProducts . " Sản phẩm cần phê duyệt"}}</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="{{route('approve.index')}}">
                <span class="float-left">{{__('Xem chi tiết')}}</span>
                <span class="float-right">
                    <i class="fas fa-angle-right"></i>
                  </span>
            </a>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card text-white bg-warning o-hidden h-100">
            <div class="card-body">
                <div class="card-body-icon">
                    <i class="fas fa-shipping-fast"></i>
                </div>
                <div class="mr-5">{{$invoiceInProgress . ' Đơn hàng chờ xử lí'}}</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="{{route('invoices.in-progress')}}">
                <span class="float-left">{{__('Xem chi tiết')}}</span>
                <span class="float-right">
                    <i class="fas fa-angle-right"></i>
                  </span>
            </a>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card text-white bg-success o-hidden h-100">
            <div class="card-body">
                <div class="card-body-icon">
                    <i class="fas fa-fw fa-shopping-cart"></i>
                </div>
                <div class="mr-5">{{$invoiceInTransport . ' Đơn hàng đang được giao'}}</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="{{route('invoices.in-transport')}}">
                <span class="float-left">{{__('Xem chi tiết')}}</span>
                <span class="float-right">
                    <i class="fas fa-angle-right"></i>
                  </span>
            </a>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card text-white bg-danger o-hidden h-100">
            <div class="card-body">
                <div class="card-body-icon">
                    <i class="fas fa-fw fa-life-ring"></i>
                </div>
                <div class="mr-5">{{$invoiceInDestroy . ' Đơn hàng bị hủy'}}</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="{{route('invoices.in-canceled')}}">
                <span class="float-left">{{__('Xem chi tiết')}}</span>
                <span class="float-right">
                    <i class="fas fa-angle-right"></i>
                  </span>
            </a>
        </div>
    </div>
</div>

<!-- Area Chart Revenue-->
<div class="card mb-3">
    <div class="card-header d-flex">
        <div>
            <i class="fas fa-chart-area"></i>
            Biểu đồ doanh thu
        </div>
        <div class="ml-2">
            <select name="" id="revenue-time">
                <option value="day">{{__('Ngày')}}</option>
                <option value="month">{{__('Tháng')}}</option>
                <option value="year">{{__('Năm')}}</option>
            </select>
        </div>
    </div>
    <div class="card-body">
        <canvas id="chart-revenue" width="100%" height="30"></canvas>
    </div>
    <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
</div>

<!-- Chart Order -->
<div class="card mb-3">
    <div class="card-header d-flex">
        <div>
            <i class="fas fa-chart-area"></i>
            Biểu đồ đơn hàng:
            <span id="time-order">
                {{\Carbon\Carbon::now()->format("d-m-Y")}}
            </span>
        </div>
        <div class="ml-2">
            <select name="" id="order-time">
                <option value="day">{{__('Ngày')}}</option>
                <option value="month">{{__('Tháng')}}</option>
                <option value="year">{{__('Năm')}}</option>
            </select>
        </div>
    </div>
    <div class="card-body">
        <canvas id="chart-order" width="100%" height="30"></canvas>
    </div>
    <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
</div>
