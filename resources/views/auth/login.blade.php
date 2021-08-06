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
                <header class="dash-login-box-header">
                    <h1>Login</h1>
                </header>
                <form action="{{ route('login') }}" method="post" autocomplete="off">
                    @method('POST')
                    @csrf

                    <label>
                        <span>E-mail: </span>
                        <input type="email" name="email" placeholder="Informe seu e-mail" required/>
                    </label>

                    <label>
                        <span class="field">Senha:</span>
                        <input type="password" name="password_check" placeholder="Informe sua senha" required/>
                    </label>

                    <button class="gradient gradient-orange radius">Entrar</button>
                </form>
            </article>
        </div>
        <div class="dash-login-right">

        </div>
    </div>
</body>
</html>
