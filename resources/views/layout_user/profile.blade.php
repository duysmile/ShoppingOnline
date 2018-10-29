<section id="profile" class="container d-flex my-4">
    <div class="menu-profile w-25">
        <div class="header p-3 font-weight-bold">
            <div>
                Duy Nguyen
            </div>
        </div>
        <ul class="nav nav-tabs d-flex flex-column">
            <li class="nav-item">
                <a class="nav-link active font-size-sm" data-toggle="tab" href="#profile-detail">Tài khoản của tôi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link font-size-sm" data-toggle="tab" href="#invoice">Đơn hàng</a>
            </li>
            <li class="nav-item">
                <a class="nav-link font-size-sm" data-toggle="tab" href="#notification">Thông báo</a>
            </li>
        </ul>
    </div>
    <div class="detail-profile w-75 tab-content bg-white pb-2">
        <div class="tab-pane container active" id="profile-detail">
            <div class="header border-bottom color-common py-2">
                <h4 class="font-size-md pb-0 mb-0">
                    Tài khoản của tôi
                </h4>
                <span class="font-size-sm text-dark">
                    Quản lý thông tin
                </span>
            </div>
            <div class="body pt-3">
                <form action="">
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="email" class="form-control rounded-0 font-size-md" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="">Số điện thoại</label>
                        <input type="text" class="form-control rounded-0 font-size-md" placeholder="Số điện thoại">
                    </div>
                    <div class="form-group">
                        <label for="">Họ và tên</label>
                        <input type="text" class="form-control rounded-0 font-size-md" placeholder="Họ và tên">
                    </div>
                    <div class="form-group">
                        <label for="">Ngày sinh</label>
                        <input type="text" class="form-control rounded-0 font-size-md" placeholder="dd/mm/YYYY">
                    </div>
                    <div class="form-group">
                        <label for="">Địa chỉ</label>
                        <input type="text" class="form-control rounded-0 font-size-md" placeholder="Địa chỉ">
                    </div>
                    <div class="form-group d-flex">
                        <label for="" class="mr-3">Giới tính</label>
                        <div class="form-check mr-2">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="optradio">Nam
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="optradio">Nữ
                            </label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-start pt-2">
                        <a href="" class="b-color-common btn text-white rounded-0 font-size-md">
                            Lưu
                        </a>
                    </div>
                </form>
            </div>
        </div>
        <div class="tab-pane container fade" id="invoice">
            <div class="header border-bottom color-common py-2">
                <h4 class="font-size-md pb-0 mb-0">
                    Đơn mua
                </h4>
                <span class="font-size-sm text-dark">
                    Quản lí đơn hàng
                </span>
            </div>
            <div class="body">
                <ul class="nav nav-pills d-flex justify-content-between">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="pill" href="#in-progress">Đang xử lí</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#in-transport">Đang giao</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#in-success">Đã giao</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#in-delete">Đã hủy</a>
                    </li>
                </ul>
                <div class="tab-content border-top">
                    <div class="tab-pane container active" id="in-progress">
                        <div class="d-flex flex-column">
                            <div class="d-flex justify-content-between item-card-header-pr">
                                <div class="h-100 d-flex align-items-center w-50">
                                    <div class="h-100 d-flex ml-4 align-items-center">
                                        Sản phẩm
                                    </div>
                                </div>
                                <div class="d-flex align-items-center w-50 justify-content-end">
                                    <p class="w-25">
                                        Đơn giá
                                    </p>
                                    <p class="w-25">
                                        Số lượng
                                    </p>
                                    <p class="w-25">
                                        Số tiền
                                    </p>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between item-card-pr">
                                <div class="h-100 d-flex align-items-center w-50 justify-content-start py-2">
                                    <div class="h-100 d-flex">
                                        <img class="cart-img h-100 mr-3" src="{{asset('images/dell1.jpg')}}" alt="">
                                        <p>
                                            Dell Inspiron
                                        </p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center w-50 justify-content-end">
                                    <p class="w-25">
                                        <u>đ</u>10.000.000
                                    </p>
                                    <p class="w-25 text-center">1</p>
                                    <p class="w-25">
                                        <u>đ</u>10.000.000
                                    </p>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end item-card-pr">
                                <div class="d-flex align-items-center w-50">
                                    <p>
                                        Tổng số tiền (1 sản phẩm)
                                    </p>
                                    <p class="w-50 size-larger color-common text-right mr-3">
                                        <u>đ</u>10.000.000
                                    </p>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end my-2">
                                <a href="" class="b-color-common p-2 text-white mr-2">
                                    Xem chi tiết
                                </a>
                                <a href="" class="b-color-common p-2 text-white">
                                    Hủy đơn hàng
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane container fade" id="in-transport">...</div>
                    <div class="tab-pane container fade" id="in-success">...</div>
                    <div class="tab-pane container fade" id="in-delete">...</div>
                </div>
            </div>
        </div>
        <div class="tab-pane container fade" id="notification">...</div>
    </div>
</section>
