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
            <article class="wallet radius {{ $wallet->balance() >= 0 ? 'gradient-green' : 'gradient-red' }}">
                <span class="wallet-remove transition" data-id="{{ $wallet->id }}">
                    <i class="fas fa-trash-alt"></i>
                </span>
                <h1>
                    <i class="fas fa-wallet"></i>
                </h1>
                <form id="{{ $wallet->id }}" action="{{ route('app.wallets.destroy', ['wallet' => $wallet]) }}" method="post">
                    @method('DELETE')
                </form>

                <form action="{{ route('app.wallets.update', ['wallet' => $wallet]) }}">
                    @method('PUT')

                    <input type="text" name="wallet" value="{{ $wallet->wallet }}" class="wallet-name">
                </form>

                <p class="wallet-balance">R$ {{ str_price($wallet->balance()) }}</p>
                <p class="wallet-income">Receitas: R$ {{ str_price($wallet->income()) }}</p>
                <p class="wallet-expense">Despesa: R$ {{ str_price($wallet->expense()) }}</p>
            </article>
        @endforeach
    </section>
@endsection
