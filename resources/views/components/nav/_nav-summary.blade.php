<ul class="nav nav-tabs mt-2 mb-3">
    <li class="nav-item">
        <a class="nav-link {{ Route::is('summary.index') ? 'active' : '' }}" href="{{ route('summary.index') }}">Přehledy ukazatelů</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Route::is('summary.clients') ? 'active' : '' }}"
            href="{{ route('summary.clients', ['from' => '2023-01-01', 'to' => '2023-12-31']) }}">Přehled klientů</a>
    </li>
</ul>
