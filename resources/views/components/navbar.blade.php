<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item {{ Request::is('/') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('home') }}">Home</a>
            </li>
            <li class="nav-item {{ Request::is('event*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('user.events.index') }}">Evenementen</a>
            </li>
            <li class="nav-item {{ Request::is('community*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('user.community.index') }}">Community</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="https://sv-concat.myspreadshop.nl" target="_blank" rel="noopener noreferrer">Webshop</a>
            </li>
            <li class="nav-item {{ Request::is('sponsors') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('user.sponsors.index') }}">Sponsoren</a>
            </li>

            @auth
                @if(auth()->user()->hasRole('admin'))
                    <li class="nav-item {{ Request::is('admin') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin') }}">Admin</a>
                    </li>
                @endif

                    <li class="nav-item {{ Request::is('profile') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('user.profile.index') }}">Profiel</a>
                    </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Uitloggen
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            @else
                <li class="nav-item {{ Request::is('register') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('register') }}">Inschrijven</a>
                </li>
                <li class="nav-item {{ Request::is('login') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('login') }}">Inloggen</a>
                </li>
            @endauth
        </ul>
    </div>
</nav>

<script>
    document.addEventListener("DOMContentLoaded", function(){
        const navbarToggler = document.querySelector(".navbar-toggler");
        const navbarCollapse = document.querySelector("#navbarNav");

        navbarToggler.addEventListener("click", function(event){
            navbarCollapse.classList.toggle("show");
            event.stopPropagation();
        });

        document.addEventListener("click", function(event) {
            if(!navbarCollapse.contains(event.target) && !navbarToggler.contains(event.target)){
                navbarCollapse.classList.remove("show");
            }
        });

        document.querySelectorAll(".navbar-nav .nav-link").forEach(item => {
            item.addEventListener("click", function (){
                navbarCollapse.classList.remove("show");
            });
        });
    });
</script>
