<div class="modal fade" id="login-dialog" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog rounded-0" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header rounded-0 d-flex align-items-center">
                <h5 class="modal-title" id="exampleModalLabel">Đăng nhập</h5>
                <a href="" data-dismiss="modal" aria-label="Close" class="color-common">
                    Đăng kí
                </a>
            </div>
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
                    </div>
                    <span class="text-danger" data-bind="server"></span>
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
                <a href="" class="bg-danger p-2 flex-grow-1 text-white text-center" style="background-color: #DB483B">
                    <i class="fab fa-google"></i>
                    Đăng nhập bằng gmail
                </a>
                <a href="" class="p-2 flex-grow-1 text-white text-center" style="background-color: rgb(58, 89, 152)">
                    <i class="fab fa-facebook-square"></i>
                    Đăng nhập bằng facebook
                </a>
            </div>
        </div>
    </div>
</div>
