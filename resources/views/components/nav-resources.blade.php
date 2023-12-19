<div>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link {{Route::is('clients.index') ? 'active' : ''}}" aria-current="page" href="{{ route('clients.index') }}">Přehled</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{Route::is('clients.create') ? 'active' : ''}}" href="{{ route('clients.create') }}">Nový</a>
        </li>
        </li>
    </ul>
</div>
