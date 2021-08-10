@extends('auth.master.master')

@section('content')
    <header class="dash-login-box-header">
        <h1>Fazer Login</h1>
        <p>Ainda não tem conta? <a href="{{ route('register') }}">Cadastre-se</a></p>
    </header>
    <form action="{{ route('login') }}" method="post" autocomplete="off">
        @method('POST')
        @csrf

        <label>
            <span>E-mail: </span>
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
                <span class="forget"><a href="{{ route('password.update') }}">Esqueceu a senha?</a></span>
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
