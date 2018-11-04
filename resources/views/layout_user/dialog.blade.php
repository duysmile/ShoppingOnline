<div class="modal fade" id="login-register-dialog" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog rounded-0" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header rounded-0">
                <div id="login-dialog-header" class="w-100">
                    <div class="d-flex align-items-center justify-content-between w-100">
                        <h5 class="modal-title" id="exampleModalLabel">Đăng nhập</h5>
                        <a href="" class="color-common" data-open="signup">
                            Đăng kí
                        </a>
                    </div>
                </div>
                <div id="signup-dialog-header" class="w-100">
                    <div class="d-flex align-items-center justify-content-between w-100">
                        <h5 class="modal-title" id="exampleModalLabel">Đăng kí</h5>
                        <a href="" class="color-common" data-open="login">
                            Đăng nhập
                        </a>
                    </div>
                </div>
            </div>
            <div id="signup-dialog-content">
                <div class="modal-body">
                    <form id="signup-form" action="{{route('signup')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <input name="username" type="text" class="form-control rounded-0 font-size-md" placeholder="Tên đăng nhập">
                            <span class="text-danger" data-bind="username"></span>
                        </div>
                        <div class="form-group">
                            <input name="email" type="email" class="form-control rounded-0 font-size-md" placeholder="Email">
                            <span class="text-danger" data-bind="email"></span>
                        </div>
                        <div class="form-group">
                            <input name="password" type="password" class="form-control rounded-0 font-size-md" placeholder="Mật khẩu">
                            <span class="text-danger" data-bind="password"></span>
                        </div>
                        <div class="form-group">
                            <input name="confirm-password" type="password" class="form-control rounded-0 font-size-md" placeholder="Xác nhận mật khẩu">
                            <span class="text-danger" data-bind="confirm-password"></span>
                        </div>
                        <div class="form-group">
                            <input name="tel" type="text" class="form-control rounded-0 font-size-md" placeholder="Số điện thoại">
                            <span class="text-danger" data-bind="tel"></span>
                            <span class="text-danger" data-bind="server"></span>
                        </div>
                        <div class="d-flex justify-content-center">
                            <div class="text-center font-size-sm">
                                Bằng việc đăng kí, bạn đã đồng ý với Shopping Online về
                                <a href="" class="color-common">Điều khoản dịch vụ</a> &
                                <a href="" class="color-common">Chính sách bảo mật</a>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end pt-5">
                            <a href="" class="btn bg-light mr-2 rounded-0 font-size-md border" data-dismiss="modal">
                                Trở lại
                            </a>
                            <input type="submit" value="Đăng kí" href="" class="b-color-common btn text-white rounded-0 font-size-md"/>
                        </div>
                    </form>
                </div>
                <div class="modal-footer bg-light d-flex justify-content-around px-2">
                    <form action="{{route('login_social', 'google')}}" method="get" class="w-50">
                        @csrf
                        <input type="hidden" name="_url" value="{{Request::url()}}">
                        <button type="submit" class=" rounded-0 btn bg-danger p-2 flex-grow-1 text-white text-center font-size-md w-100" style="background-color: #DB483B">
                            <i class="fab fa-google"></i>
                            Tiếp tục với google
                        </button>
                    </form>
                    <form action="{{route('login_social', 'facebook')}}" method="get" class="w-50">
                        @csrf
                        <input type="hidden" name="_url" value="{{Request::url()}}">
                        <button type="submit" class="btn rounded-0 p-2 flex-grow-1 text-white text-center font-size-md w-100" style="background-color: rgb(58, 89, 152)">
                            <i class="fab fa-facebook-square"></i>
                            Tiếp tục với facebook
                        </button>
                    </form>
                </div>
            </div>
            <div id="login-dialog-content">
                <div class="modal-body">
                    <form action="{{route('login')}}" method="post" id="login-form">
                        @csrf
                        <div class="form-group">
                            <input type="text" name="id_login" class="form-control rounded-0 font-size-md" placeholder="{{__('Email/Tên đăng nhập')}}">
                            <span class="text-danger" data-bind="id_login"></span>
                        </div>
                        <div class="form-group">
                            <input type="password" name="pass_login" class="form-control rounded-0 font-size-md" placeholder="{{__('Mật khẩu')}}">
                            <span class="text-danger" data-bind="pass_login"></span>
                            <span class="text-danger" data-bind="server"></span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div>
                                <label class="custom-checkbox d-inline">
                                    <input type="checkbox" name="remember_me">
                                    <div class="checkbox-box"></div>
                                </label>
                                <label for="" style="margin-left: 24px">
                                    Duy trì đăng nhập
                                </label>
                            </div>
                            <a href="" class="color-common">
                                Quên mật khẩu
                            </a>
                        </div>
                        <div class="d-flex justify-content-end pt-5">
                            <a href="" class="btn bg-light mr-2 rounded-0 font-size-md border" data-dismiss="modal">
                                Trở lại
                            </a>
                            <input type="submit" value="{{__('Đăng nhập')}}" class="b-color-common btn text-white rounded-0 font-size-md"/>
                        </div>
                    </form>
                </div>
                <div class="modal-footer bg-light d-flex justify-content-around px-2">
                    <form action="{{route('login_social', 'google')}}" method="get" class="w-50">
                        @csrf
                        <input type="hidden" name="_url" value="{{Request::url()}}">
                        <button type="submit" class=" btn rounded-0 bg-danger p-2 flex-grow-1 text-white text-center font-size-md w-100" style="background-color: #DB483B">
                            <i class="fab fa-google"></i>
                            Đăng nhập bằng google
                        </button>
                    </form>
                    <form action="{{route('login_social', 'facebook')}}" method="get" class="w-50">
                        @csrf
                        <input type="hidden" name="_url" value="{{Request::url()}}">
                        <button type="submit" class="btn rounded-0 p-2 flex-grow-1 text-white text-center font-size-md w-100" style="background-color: rgb(58, 89, 152)">
                            <i class="fab fa-facebook-square"></i>
                            Đăng nhập bằng facebook
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
