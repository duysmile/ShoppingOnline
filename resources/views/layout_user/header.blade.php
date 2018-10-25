<!-- Header -->
<header class="container-fluid main-header--height d-flex justify-content-between align-items-center bg-white">
    <div class="h-100 mr-3">
        <img class="h-100" src="{{asset('images/logo.jpg')}}" alt="Logo here">
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
<nav class="navbar navbar-expand-sm navbar-light sticky-top bg-white nav__menu--box-shadow">
    <button class="navbar-toggler border bg-light" type="button" data-toggle="collapse" data-target="#navMenu">
        <span class="navbar-toggler-icon "></span>
    </button>
    <div class="collapse navbar-collapse w-100" id="navMenu">
        <div class="d-flex flex-md-row flex-column justify-content-md-around align-items-md-center w-100">
            <div class="nav__button nav__categories--padding">
                <h4>
                    <i class="fa fa-list pr-2"></i>
                    <a class="text-dark" href="#">Categories</a>
                </h4>
            </div>
            <div class="w-50">
                <form action="" class="form-inline w-100">
                    <div class="input-group w-100 border-common-lg">
                        <input type="text" class="form-control border-0 nav__input-search" placeholder="What are you looking for ... ">
                        <div class="input-group-prepend">
                                <span class="input-group-text bg-common text-white border-0">
                                    <i class="fa fa-search pr-2 text-white"></i>
                                    Search
                                </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="d-flex">
                <div class="nav__button p-2">
                    <i class="fa fa-user p-2"></i>
                    <a href="">
                        Login <span style="color:#ccc">|</span> Sign up free
                    </a>
                </div>
                <div class="nav__button p-2">
                    <i class="fa fa-shopping-cart p-2"></i>
                    <a href="">
                        Cart
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>
