<ul class="sidebar navbar-nav">
    <li class="nav-item active">
        <a class="nav-link" href="/admin">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>{{__('Dashboard')}}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('categories.index')}}">
            <i class="fas fa-list"></i>
            <span>{{__('Quản lí danh mục')}}</span>
        </a>
        <a class="nav-link" href="{{route('products.index')}}">
            <i class="fas fa-shopping-bag"></i>
            <span>{{__('Quản lí sản phẩm')}}</span>
        </a>
        {{--<div class="collapse bg-light" id="pagesDropdown">--}}
            {{--<h6 class="dropdown-header">Login Screens:</h6>--}}
            {{--<a class="dropdown-item" href="login.html">Login</a>--}}
            {{--<a class="dropdown-item" href="register.html">Register</a>--}}
            {{--<a class="dropdown-item" href="forgot-password.html">Forgot Password</a>--}}
            {{--<div class="dropdown-divider"></div>--}}
            {{--<h6 class="dropdown-header">Other Pages:</h6>--}}
            {{--<a class="dropdown-item" href="404.html">404 Page</a>--}}
            {{--<a class="dropdown-item" href="blank.html">Blank Page</a>--}}
        {{--</div>--}}
    </li>
    <li class="nav-item">
        <a class="nav-link" href="charts.html">
            <i class="fas fa-users"></i>
            <span>{{__('Quản lí user')}}</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="tables.html">
            <i class="fas fa-shipping-fast"></i>
            <span>{{__('Quản lí đơn hàng')}}</span></a>
    </li>
</ul>
