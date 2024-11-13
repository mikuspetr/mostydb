<section id="menu" class="container-fluid">
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <span class="navbar-brand">Mosty</span>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{Route::is('home') ? 'active' : ''}}" aria-current="page" href="{{route('home')}}">Domů</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{Route::is('clients.*') ? 'active' : ''}}" href="{{route('clients.index')}}">Klienti</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{Route::is('users.*') ? 'active' : ''}}" href="{{route('users.index')}}">Pracovníci</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{Route::is('records.*') ? 'active' : ''}}" href="{{route('records.index')}}">Záznamy</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{Route::is('summary.*') ? 'active' : ''}}" href="{{route('summary.clients', ['from'=>'2023-01-01', 'to'=>'2023-12-31'])}}">Přehledy</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{Route::is('debug.*') ? 'active' : ''}}" href="{{route('debug')}}">Debug</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarScrollingDropdown">
                            <li><a class="dropdown-item" href="{{route('profile.edit')}}">{{ __('Profile') }}</a></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a class="dropdown-item" href="{{route('logout')}}" onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </a>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</section>
