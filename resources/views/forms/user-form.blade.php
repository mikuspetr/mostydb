<form action="{{ isset($user) ? route('users.update', [$user->id]) : route('users.store') }}" method="POST">
    @csrf
    @if(isset($user))
        @method('PUT')
    @endif

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Osobní údaje</h5>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <x-forms.input-label for="name" value="Jméno" />
                <x-forms.text-input 
                    id="name" 
                    class="form-control @error('name') is-invalid @enderror" 
                    type="text" 
                    name="name" 
                    required
                    value="{{ isset($user) ? $user->name : old('name') }}" 
                />
                @error('name')
                    <x-forms.input-error :messages="$errors->get('name')" />
                @enderror
            </div>
            <div class="mb-3">
                <x-forms.input-label for="login" value="Login" />
                <x-forms.text-input 
                    id="login" 
                    class="form-control @error('login') is-invalid @enderror" 
                    type="text" 
                    name="login" 
                    required
                    value="{{ isset($user) ? $user->login : old('login') }}" 
                />
                @error('login')
                    <x-forms.input-error :messages="$errors->get('login')" />
                @enderror
            </div>

            <div class="mb-3">
                <x-forms.input-label for="email" value="Email" />
                <x-forms.text-input 
                    id="email" 
                    class="form-control @error('email') is-invalid @enderror" 
                    type="email" 
                    name="email" 
                    required
                    value="{{ isset($user) ? $user->email : old('email') }}" 
                />
                @error('email')
                    <x-forms.input-error :messages="$errors->get('email')" />
                @enderror
            </div>

            @if(!isset($user))
                <div class="mb-3">
                    <x-forms.input-label for="password" value="Heslo" />
                    <x-forms.text-input 
                        id="password" 
                        class="form-control @error('password') is-invalid @enderror" 
                        type="password" 
                        name="password" 
                        required
                    />
                    @error('password')
                        <x-forms.input-error :messages="$errors->get('password')" />
                    @enderror
                    <small class="form-text text-muted">Zadejte bezpečné heslo o délce alespoň 8 znaků.</small>
                </div>

                <div class="mb-3">
                    <x-forms.input-label for="password_confirmation" value="Potvrzení hesla" />
                    <x-forms.text-input 
                        id="password_confirmation" 
                        class="form-control @error('password_confirmation') is-invalid @enderror" 
                        type="password" 
                        name="password_confirmation" 
                        required
                    />
                    @error('password_confirmation')
                        <x-forms.input-error :messages="$errors->get('password_confirmation')" />
                    @enderror
                </div>
            @endif
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header">
            <h5 class="card-title">Role</h5>
        </div>
        <div class="card-body">
            @forelse($roles as $role)
                <div class="form-check">
                    <input 
                        class="form-check-input" 
                        type="checkbox" 
                        name="roles[]" 
                        value="{{ $role->name }}"
                        id="role_{{ $role->id }}" 
                        {{ isset($user) && $user->hasRole($role->name) ? 'checked' : '' }}
                    >
                    <label class="form-check-label" for="role_{{ $role->id }}">
                        {{ $role->name }}
                        <small class="text-muted">({{ $role->permissions->pluck('name')->join(', ') }})</small>
                    </label>
                </div>
            @empty
                <p class="text-muted">Žádné role nejsou dostupné.</p>
            @endforelse
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('users.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Zpět
        </a>
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-check"></i> {{ isset($user) ? 'Uložit změny' : 'Vytvořit pracovníka' }}
        </button>
    </div>
</form>
