@extends('auth.master.master')

@section('content')
    <header class="dash-login-box-header">
        <h1>Redefinir senha</h1>
    </header>
    <form action="{{ route('password.update') }}" method="post">
        @method('POST')
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <label>
            <span>Email: </span>
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

        <button class="gradient gradient-green radius">Registrar</button>
    </form>
@endsection
