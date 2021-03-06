@extends('auth.master.master')

@section('content')
    <header class="dash-login-box-header">
        <h1>Recuperar Senha</h1>
        <p>Ainda não tem conta? <a href="{{ route('register') }}">Cadastre-se</a></p>
    </header>
    @if (session('status'))
        <div class="message message-success">
            {{ session('status') }}
        </div>
    @endif

    <form action="{{ route('password.email') }}" method="post" autocomplete="off">
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

        <button class="gradient gradient-green radius">Enviar</button>
    </form>
@endsection
