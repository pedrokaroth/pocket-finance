<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ url(asset('/auth/assets/css/login.css')) }}">
    <link rel="stylesheet" href="{{ url(asset('/auth/assets/css/boot.css')) }}">
    <link rel="stylesheet" href="{{ url(asset('/auth/assets/css/reset.css')) }}">
    <title>Document</title>
</head>
<body>
<div class="dash-login">
    <div class="dash-login-left">
        <article class="dash-login-left-box">
            @yield('content')
        </article>
    </div>
    <div class="dash-login-right">

    </div>
</div>
</body>
</html>
