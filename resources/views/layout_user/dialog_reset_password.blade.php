<div class="modal fade" id="new-password-dialog" tabindex="-1" role="dialog">
    <div class="modal-dialog rounded-0" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header rounded-0">
                <div class="w-100">
                    <div class="d-flex align-items-center justify-content-between w-100">
                        <h5 class="modal-title">{{_('Đặt lại mật khẩu')}}</h5>
                    </div>
                </div>
            </div>
            <div>
                <div class="modal-body" id="new-password-content">
                    <form id="new-password-form" action="{{route('reset_password')}}" method="post">
                        @csrf
                        <input type="hidden" name="token" value="{{$token}}">
                        <div class="form-group">
                            <input name="password" type="password" class="form-control rounded-0 font-size-md"
                                   placeholder="Mật khẩu mới">
                            <span class="text-danger" data-bind="password"></span>
                        </div>
                        <div class="form-group">
                            <input name="confirm-password" type="password" class="form-control rounded-0 font-size-md"
                                   placeholder="Xác nhận mật khẩu">
                            <span class="text-danger" data-bind="confirm-password"></span>
                        </div>
                        <span class="text-danger" data-bind="server"></span>
                        <div class="d-flex justify-content-center">
                        </div>
                        <div class="d-flex justify-content-end pt-3">
                            <a href="" class="btn bg-light mr-2 rounded-0 font-size-md border" data-dismiss="modal">
                                Trở lại
                            </a>
                            <input type="submit" value="Hoàn thành" href=""
                                   class="b-color-common btn text-white rounded-0 font-size-md"/>
                        </div>
                    </form>
                </div>
                <div class="modal-body" id="new-password-confirm-content">
                    <div>
                        Bạn đã thay đổi mật khẩu thành công.
                    </div>
                    <div class="d-flex justify-content-end pt-3">
                        <a href="" class="btn bg-light mr-2 rounded-0 font-size-md border" data-dismiss="modal">
                            Trở lại
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
