<nav class="sidebar">
    <div class="sidebar-title sidebar-user">
        <span class="user">
            <img class="rounded-full" src="{{ asset('img/avatar.jpg') }}" alt="">
            <span>Pedro</span>
        </span>
    </div>
    <hr>
    <div class="sidebar-nav">
        <div class="logout">
            <a href="{{ route('logout') }}" class="nav_link radius" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i>
                Sair
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>
</nav>