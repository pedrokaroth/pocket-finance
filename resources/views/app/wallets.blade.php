@extends('app.master.master')

@section('content')
    <section class="app-wallets">
        <article class="wallet radius gradient-blue">
            <h1><i class="fas fa-money-check-alt"></i></h1>
            <h5>Gerencie suas carteiras</h5>
            <p>
                Use suas carteiras para monitorar seus gastos de <b>Casa</b>, seus <b>Investimentos</b> ou até mesmo
                para controlar seus <b>cartões.</b> A partir daqui você está no <b>controle</b> do seu bolso.
            </p>

            <span class="btn-overlay-open radius transition" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus-circle"></i> Criar Carteira</span>

            <div class="wallet-overlay radius">
                <div>
                    <p>Para começar, você pode escolher entre <b>Minha casa</b>,
                        <b>Minha empresa</b> ou até mesmo <b>cartão 5578</b>...</p>
                    <form action="{{ route('app.wallets.store') }}" method="post" autocomplete="off">
                        @method('POST')
                        @csrf

                        <input type="text" name="wallet" placeholder="Ex: Casa, Empresa, Cartão 5546" required="">
                        <button class="btn-save radius transition">
                            Abrir Carteira
                        </button>

                        <span class="btn-overlay-close transition">
                            <i class="fas fa-sign-out-alt"></i>
                            Voltar
                        </span>
                    </form>
                </div>
            </div>
        </article>

        @foreach($wallets as $wallet)
            <article class="wallet radius gradient-green">
                <span class="wallet-remove transition">
                    <i class="fas fa-trash-alt"></i>
                </span>
                <h1>
                    <i class="fas fa-wallet"></i>
                </h1>
                <input type="text" value="{{ $wallet->wallet }}">
                <p class="wallet-balance">R$ {{ $wallet->balance }}</p>
                <p class="wallet-income">Receitas: R$ {{ $wallet->income }}</p>
                <p class="wallet-expense">Despesa: R$ {{ $wallet->expense }}</p>
            </article>
        @endforeach
    </section>
@endsection