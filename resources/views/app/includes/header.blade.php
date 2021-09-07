<header class="app-header">
    <h1>
        <a href="{{ route('app.home') }}" class="">
            <i class="fas fa-money-bill-wave"></i>
            PocketApp
        </a>
    </h1>
    @if(\App\Models\App\Wallet::free())
        <ul class="header-wallet">
            <li class="wallet-dropdown">
                    {{ walletactive()->wallet }}
                    <ul style="display: none">
                        @foreach(wallets() as $wallet)
                            <li data-wallet="{{ $wallet->id }}" data-endpoint="{{ route('app.wallets.filter', $wallet->id) }}" class="wallet-change">{{ $wallet->wallet }}</li>
                        @endforeach
                    </ul>
            </li>
        </ul>
    @endif
</header>
