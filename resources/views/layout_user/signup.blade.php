<div class="modal fade" id="signup-dialog" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog rounded-0" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header rounded-0 d-flex align-items-center">
                <h5 class="modal-title" id="exampleModalLabel">Đăng kí</h5>
                <a href="" data-dismiss="modal" aria-label="Close" class="color-common"
                   data-toggle="modal" data-target="signup-dialog">
                    Đăng nhập
                </a>
            </div>
            <div class="modal-body">
                <form id="signup-form" action="{{route('signup')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <input name="username" type="text" class="form-control rounded-0 font-size-md" placeholder="Tên đăng nhập">
                    </div>
                    <div class="form-group">
                        <input name="email" type="email" class="form-control rounded-0 font-size-md" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <input name="password" type="password" class="form-control rounded-0 font-size-md" placeholder="Mật khẩu">
                    </div>
                    <div class="form-group">
                        <input name="confirm-password" type="password" class="form-control rounded-0 font-size-md" placeholder="Xác nhận mật khẩu">
                    </div>
                    <div class="form-group">
                        <input name="tel" type="text" class="form-control rounded-0 font-size-md" placeholder="Số điện thoại">
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
                <a href="" class="bg-danger p-2 flex-grow-1 text-white text-center" style="background-color: #DB483B">
                    <i class="fab fa-google"></i>
                    Tiếp tục với gmail
                </a>
                <a href="" class="p-2 flex-grow-1 text-white text-center" style="background-color: rgb(58, 89, 152)">
                    <i class="fab fa-facebook-square"></i>
                    Tiếp tục với facebook
                </a>
            </div>
        </div>
    </div>
</div>
