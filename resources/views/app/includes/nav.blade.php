<nav class="sidebar radius">
    <div class="sidebar-title sidebar-user">
        <span class="user">
            <img class="rounded-full" src="{{ asset('img/avatar.jpg') }}" alt="">
            <span>{{ user()->first_name }}</span>
        </span>
    </div>
    <hr>
    <div class="sidebar-nav">
        <a href="{{ route('app.wallets') }}" class="nav_link {{ isActive('app.wallets') }}">
            <i class="fas fa-wallet"></i>
            <span>Carteiras</span>
        </a>
        <a href="{{ route('app.expenses') }}" class="nav_link {{ isActive('app.expenses') }}">
            <i class="fas fa-funnel-dollar"></i>
            <span>Despesas</span>
        </a>
        <a href="{{ route('app.incomes') }}" class="nav_link {{ isActive('app.incomes') }}">
            <i class="fas fa-coins"></i>
            <span>Receitas</span>
        </a>
        <a href="{{ route('app.fixed') }}" class="nav_link {{ isActive('app.fixed') }}">
            <i class="fas fa-history"></i>
            <span>Fixas</span>
        </a>
        <div class="logout">
            <a href="{{ route('logout') }}" class="nav_link" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i>
                <span style="">Sair</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>
</nav>
