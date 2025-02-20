<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Concat</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item {{ Request::is('/') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/') }}">Home</a>
            </li>
            <li class="nav-item {{ Request::is('Evenementen') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/Evenementen') }}">Evenementen</a>
            </li>
            <li class="nav-item {{ Request::is('Inloggen') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/Inloggen') }}">Inloggen</a>
            </li>
        </ul>
    </div>
</nav>

<style>
    .navbar-nav .nav-item.active .nav-link
    {
        font-weight: bold;
    }
</style>
