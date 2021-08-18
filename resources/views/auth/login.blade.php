@extends('auth.master.master')

@section('content')
    <header class="dash-login-box-header">
        <h1>LOGIN</h1>
        <p>Não tem uma conta? <a href="{{ route('register') }}">Crie uma!</a></p>
    </header>
    <form action="{{ route('login') }}" method="post" autocomplete="off">
        @method('POST')
        @csrf

        <label>
            <span class="field">E-mail: </span>
            <input type="email" name="email" placeholder="Informe seu e-mail" required/>
            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </label>

        <label>
            <div class="password-login">
                <span class="field">Senha:</span>
                <span class="forget"><a href="{{ route('password.update') }}">Esqueceu sua senha?</a></span>
            </div>
            <input type="password" name="password" placeholder="Informe sua senha" required/>
            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </label>

        <button class="gradient gradient-orange radius">Entrar</button>
    </form>
@endsection
