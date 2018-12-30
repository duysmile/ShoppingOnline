<ul class="sidebar navbar-nav">
    <li class="nav-item active">
        <a class="nav-link" href="/admin">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>{{__('Dashboard')}}</span>
        </a>
    </li>
    <li class="nav-item">
        @role('admin')
        <a class="nav-link" href="{{route('approve.index')}}">
            <i class="fas fa-clipboard-check"></i>
            <span>{{__('Phê duyệt')}}</span>
        </a>
        <a class="nav-link" href="{{route('categories.index')}}">
            <i class="fas fa-list"></i>
            <span>{{__('Quản lí danh mục')}}</span>
        </a>
        @endrole
        <a class="nav-link" href="{{route('products.index')}}">
            <i class="fas fa-shopping-bag"></i>
            <span>{{__('Quản lí sản phẩm')}}</span>
        </a>
    </li>
    @role('admin')
    <li class="nav-item">
        <a class="nav-link" href=""
           data-toggle="collapse" data-target="#user-type">
            <i class="fas fa-users"></i>
            <span>{{__('Quản lí user')}}</span>
        </a>
        <div class="collapse bg-light" id="user-type">
            <a class="dropdown-item" href="{{route('users.index')}}">
                <i class="fa fa-user font-size-md"></i>
                {{__('Customer')}}
            </a>
            <a class="dropdown-item" href="{{route('users.staff')}}">
                <i class="fa fa-user-tie font-size-md"></i>
                {{__('Staff')}}
            </a>
        </div>
    </li>
    @endrole
    <li class="nav-item">
        <a class="nav-link" href=""
           data-toggle="collapse" data-target="#invoices-status">
            <i class="fas fa-shipping-fast"></i>
            <span>
                {{__('Quản lí đơn hàng')}}
            </span>
        </a>
        <div class="collapse bg-light" id="invoices-status">
            <a class="dropdown-item" href="{{route('invoices.in-progress')}}">
                <i class="fa fa-spinner font-size-md"></i>
                {{__('Chờ xét duyệt')}}
                @if($countInvoices['countInProgress'] > 0)
                    <span class="badge badge-danger font-size-sm text-white">{{$countInvoices['countInProgress']}}</span>
                @endif
            </a>
            <a class="dropdown-item" href="{{route('invoices.in-transport')}}">
                <i class="fa fa-truck font-size-md"></i>
                {{__('Đang giao')}}
                @if($countInvoices['countOnTheWay'] > 0)
                    <span class="badge badge-success font-size-sm text-white">{{$countInvoices['countOnTheWay']}}</span>
                @endif
            </a>
            <a class="dropdown-item" href="{{route('invoices.in-success')}}">
                <i class="fa fa-check-circle font-size-md"></i>
                {{__('Đã giao')}}
            </a>
            <a class="dropdown-item" href="{{route('invoices.in-canceled')}}">
                <i class="fa fa-trash font-size-md"></i>
                {{__('Bị hủy')}}
            </a>
        </div>
    </li>
</ul>
