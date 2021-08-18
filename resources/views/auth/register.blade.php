@extends('auth.master.master')

@section('content')
    <header class="dash-login-box-header">
        <h1>Cadastre-se</h1>
        <p>Já tem uma conta? <a href="{{ route('login') }}">Fazer login</a></p>
    </header>
    <form action="{{ route('register') }}" method="post">
        @method('POST')
        @csrf

        <label>
            <span class="field">Nome: </span>
            <input type="text" name="first_name" placeholder="Informe seu Nome"  value="{{ old('first_name') }}"/>
            @error('first_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </label>

        <label>
            <span class="field">Sobrenome: </span>
            <input type="text" name="last_name" placeholder="Informe seu Sobrenome"  value="{{ old('last_name') }}"/>
            @error('last_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </label>

        <label>
            <span class="field">Email: </span>
            <input type="email" name="email" placeholder="Informe seu e-mail"  value="{{ old('email') }}"/>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </label>

        <div class="password">
            <label>
                <span class="field">Senha:</span>
                <input type="password" name="password" placeholder="Informe sua senha" />
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </label>
            <label>
                <span class="field">Senha:</span>
                <input type="password" name="password_confirmation" placeholder="Informe sua senha" />
            </label>
        </div>

        <button class="gradient gradient-orange radius">Registrar</button>
    </form>
@endsection
