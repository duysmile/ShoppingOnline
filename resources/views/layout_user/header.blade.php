<!-- Header -->
<header class="container-fluid main-header--height d-flex justify-content-between align-items-center bg-white">
    <div class="h-100 pr-4 mr-5 ml-1 pl-5">
        <a href="/">
            <img class="h-100" src="{{asset('images/logo.jpg')}}" alt="Logo here">
        </a>
    </div>
    <nav class="navbar navbar-expand-sm">
        <div class="collapse navbar-collapse" id="nav-menu">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link btn-common" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn-common" href="#">Contact</a>
                </li>
            </ul>
        </div>
    </nav>
</header>

<!-- Navbar -->
<nav class="navbar navbar-expand-sm navbar-light sticky-top bg-white nav__menu--box-shadow pt-0 mt-0">
    <button class="navbar-toggler border bg-light" type="button" data-toggle="collapse" data-target="#navMenu">
        <span class="navbar-toggler-icon "></span>
    </button>
    <div class="collapse navbar-collapse w-100" id="navMenu">
        <div class="d-flex flex-md-row flex-column justify-content-md-around align-items-md-center w-100">
            <div class="nav__button position-relative custom-dropdown-block">
                <h4 class="font-size-md pb-3">
                    <i class="fa fa-list pr-2 color-common"></i>
                    <a class="text-dark" href="#">Danh mục</a>
                </h4>
                <div class="custom-dropdown-menu">
                    <ul>
                        <li>
                            <a href="">Laptop</a>
                            <i class="fa fa-chevron-right color-common"></i>
                            <div class="custom-child-dropdown-menu">
                                <ul>
                                    <li>
                                        <a href="">Gaming</a>
                                    </li>
                                    <li>
                                        <a href="">Mac</a>
                                    </li>
                                    <li>
                                        <a href="">Alienware</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="">Mobile</a>
                            <i class="fa fa-chevron-right color-common"></i>
                            <div class="custom-child-dropdown-menu">
                                <ul>
                                    <li>
                                        <a href="">Iphone</a>
                                    </li>
                                    <li>
                                        <a href="">Asus</a>
                                    </li>
                                    <li>
                                        <a href="">Xiaomi</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="">Smart TV</a>
                            <i class="fa fa-chevron-right color-common"></i>
                        </li>
                        <li>
                            <a href="">PC</a>
                            <i class="fa fa-chevron-right color-common"></i>
                        </li>
                        <li>
                            <a href="">Stereo</a>
                            <i class="fa fa-chevron-right color-common"></i>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="w-50">
                <form action="" class="form-inline w-100">
                    <div class="input-group w-100 border-common-lg">
                        <input type="text" class="form-control border-0 nav__input-search font-size-md" placeholder="What are you looking for ... ">
                        <div class="input-group-prepend">
                                <span class="input-group-text bg-common text-white border-0">
                                    <i class="fa fa-search pr-2 text-white"></i>
                                    <a href="" class="text-white">
                                        Search
                                    </a>
                                </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="d-flex">
                @if(!Auth::check())
                <div class="nav__button p-2">
                    <i class="fa fa-user p-2 color-common"></i>
                    <a href="" data-toggle="modal" data-target="#login-register-dialog" data-open="login">
                        Login
                    </a>
                    <span style="color:#ccc">|</span>
                    <a href="" data-toggle="modal" data-target="#login-register-dialog" data-open="signup">
                        Signup for free
                    </a>
                </div>
                @else
                    <div class="nav__button position-relative custom-dropdown-block pt-2">
                        <i class="fa fa-user p-2 color-common"></i>
                        <a href="{{route('profile-user')}}">
                            {{Auth::user()->name}}
                        </a>
                        <div class="custom-dropdown-menu custom-dropdown-menu-right">
                            <ul>
                                <li>
                                    <a href="{{route('profile-user')}}" class="text-white">Tài khoản của tôi</a>
                                </li>
                                <li>
                                    <a href="{{route('logout')}}" class="text-white">Đăng xuất</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                @endif
                <div class="nav__button p-2">
                    <i class="fa fa-shopping-cart p-2 color-common"></i>
                    <a href="/cart">
                        Cart
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>
