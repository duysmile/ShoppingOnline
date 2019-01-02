<section id="profile" class="container d-flex my-4">
    <div class="menu-profile w-25">
        <div class="header p-3 font-weight-bold">
            <div>
                {{$user->name}}
            </div>
        </div>
        <ul class="nav nav-tabs d-flex flex-column">
            <li class="nav-item">
                <a class="nav-link @if(session('active') == 1) active @endif font-size-sm" data-toggle="tab"
                   href="#profile-detail">{{__('Tài khoản của tôi')}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if(session('active') == 2) active @endif font-size-sm" data-toggle="tab"
                   href="#invoice">{{__('Đơn hàng')}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if(session('active') == 3) active @endif font-size-sm" data-toggle="tab"
                   href="#notification">{{__('Thông báo')}}</a>
            </li>
        </ul>
    </div>
    <div class="detail-profile w-75 tab-content bg-white pb-2">
        <div class="tab-pane container active" id="profile-detail">
            <div class="header border-bottom color-common py-2">
                <h4 class="font-size-md pb-0 mb-0">
                    {{__('Tài khoản của tôi')}}
                </h4>
                <span class="font-size-sm text-dark">
                    {{__('Quản lý thông tin')}}
                </span>
            </div>
            <div class="body pt-3">
                <form id="change-info" action="{{route('update-profile')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="">{{__('Email')}}</label>
                        <input type="email" class="form-control rounded-0 font-size-md" name="email"
                               value="{{$user->email}}" disabled placeholder="{{__('Email')}}">
                        <span class="text-danger" data-bind="email"></span>
                    </div>
                    <div class="form-group">
                        <label for="">{{__('Số điện thoại')}}</label>
                        <input type="text" class="form-control rounded-0 font-size-md" name="tel"
                               value="{{$user->info->tel_no}}" placeholder="{{__('Số điện thoại')}}">
                        <span class="text-danger" data-bind="tel"></span>
                    </div>
                    <div class="form-group">
                        <label for="">{{__('Họ và tên')}}</label>
                        <input type="text" class="form-control rounded-0 font-size-md" name="name"
                               value="{{$user->info->name}}" placeholder="{{_('Họ và tên')}}">
                        <span class="text-danger" data-bind="name"></span>
                    </div>
                    <div class="form-group">
                        <label for="">{{__('Ngày sinh')}}</label>
                        <input type="date" class="form-control rounded-0 font-size-md" name="birth_date"
                               value="{{$user->info->birth_date}}" placeholder="dd/mm/YYYY">
                        <span class="text-danger" data-bind="birth_date"></span>
                    </div>

                    <div class="d-flex">
                        <label>{{__('Địa chỉ')}}</label>
                        <a href="javascript:void(0)" data-toggle="collapse" data-target="#address-change"
                           class="ml-3 text-primary">{{__('Thay đổi')}}</a>
                    </div>

                    <div class="form-group">
                        <span id="address" class="font-size-md">
                            {{Auth::user()->info->address}}
                        </span>
                    </div>
                    <div class="collapse" id="address-change">
                        <div class="form-group">
                            <select name="city" type="text" class="form-control rounded-0 font-size-md" required>
                            </select>
                            <span class="text-danger" data-bind="city"></span>
                        </div>
                        <div class="form-group">
                            <select name="district" type="text" class="form-control rounded-0 font-size-md" required>
                            </select>
                            <span class="text-danger" data-bind="district"></span>
                        </div>
                        <div class="form-group">
                            <select name="guild" type="text" class="form-control rounded-0 font-size-md" required>
                            </select>
                            <span class="text-danger" data-bind="guild"></span>
                        </div>
                        <div class="form-group">
                            <input name="street" type="text" class="form-control rounded-0 font-size-md"
                                   placeholder="{{__('Tòa nhà/Tên đường')}}">
                            <span class="text-danger" data-bind="street"></span>
                        </div>
                    </div>

                    <div class="form-group d-flex">
                        <label for="" class="mr-3">{{__('Giới tính')}}</label>
                        <div class="form-check mr-2">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="gender" value="false"
                                       @if($user->info->gender == 0) checked @endif
                                       name="optradio">{{__('Nam')}}
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="gender" value="true"
                                       @if($user->info->gender == 1) checked @endif
                                       name="optradio">{{__('Nữ')}}
                            </label>
                        </div>
                        <span class="text-danger" data-bind="gender"></span>
                    </div>

                    <div class="d-flex justify-content-start align-items-center pt-2">
                        <input type="hidden" name="curAddress" value="{{Auth::user()->info->address}}">
                        <button href="" class="b-color-common btn text-white rounded-0 font-size-md">
                            {{__('Lưu')}}
                        </button>
                        <span class="text-success ml-3" id="notice-success"></span>
                    </div>
                </form>
            </div>
        </div>
        <div class="tab-pane container fade" id="invoice">
            <div class="header border-bottom color-common py-2">
                <h4 class="font-size-md pb-0 mb-0">
                    {{__('Đơn mua')}}
                </h4>
                <span class="font-size-sm text-dark">
                    {{__('Quản lí đơn hàng')}}
                </span>
            </div>
            <div class="body">
                <ul class="nav nav-pills d-flex justify-content-between">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="pill" href="#in-progress">
                            {{__('Đang xử lí')}}
                            <span data-bind="in-progress"></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#in-transport">
                            {{__('Đang giao')}}
                            <span data-bind="in-transport"></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#in-transported">
                            {{__('Đã giao')}}
                            <span data-bind="in-transported"></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#in-delete">
                            {{__('Đã hủy')}}
                            <span data-bind="in-delete"></span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content border-top">
                    <div class="tab-pane container active" id="in-progress"></div>
                    <div class="tab-pane container fade" id="in-transport"></div>
                    <div class="tab-pane container fade" id="in-transported"></div>
                    <div class="tab-pane container fade" id="in-delete"></div>
                </div>
            </div>
        </div>
        <div class="tab-pane container fade" id="notification">...</div>
    </div>
</section>
