<!DOCTYPE html>
<html>
<head>
    <title>Shopping online - thiết lập lại mật khẩu</title>
</head>

<body>
<h2>Xin chào {{$user['name']}},</h2>
<br/>
<p>
    Bạn đã yêu cầu thiết lập lại mật khẩu của mình trên Shopping Online.
</p>
<p>
    Để thiết lập lại, bạn chỉ cần click vào
    <a href="{{url('user/forgot-password', $user->passwordReset->token)}}">đây</a>
    và chọn mật khẩu mới.
</p>
<br/>
</body>
</html>
