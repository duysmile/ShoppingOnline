<!DOCTYPE html>
<html>
<head>
    <title>Shopping online - kích hoạt tài khoản</title>
</head>

<body>
<h2>Chào mừng {{$user['name']}} đến với Shopping Online,</h2>
<br/>
Bạn đã dùng email {{$user['email']}} để đăng kí tài khoản. Vui lòng click vào link bên dưới để xác nhận tài khoản.
<br/>
<a href="{{url('user/verify', $user->verifyUser->token)}}">Kích hoạt tài khoản</a>
<p>
    Thân.
</p>
</body>

</html>
