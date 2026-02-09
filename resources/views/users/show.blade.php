@extends('templates.main')
@section('content')
{{--
<x-crud.header>
    Detail uživatele: {{ $user->name }}
    @if(Auth::user()->hasPermissionTo('edit users permisions'))
    <div class="float-end">
        <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Zpět na seznam
        </a>
        <a href="{{ route('users.edit', $user) }}" class="btn btn-primary btn-sm">
            <i class="bi bi-pencil-square"></i> Upravit uživatele
        </a>
    </div>
    @endif
</x-crud.header>
 --}}
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Informace o uživateli</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <tr>
                        <th>ID:</th>
                        <td>{{ $user->id }}</td>
                    </tr>
                    <tr>
                        <th>Jméno:</th>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th>Login:</th>
                        <td>{{ $user->login }}</td>
                    </tr>
                    <tr>
                        <th>Vytvořen:</th>
                        <td>{{ $user->created_at?->format('d.m.Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Aktualizován:</th>
                        <td>{{ $user->updated_at?->format('d.m.Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Role a oprávnění</h5>

                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editPermissionsModal">
                    <i class="bi bi-shield-check"></i> Upravit oprávnění
                </button>

            </div>
            <div class="card-body">
                <h6>Současné role:</h6>
                <div class="mb-3">
                    @forelse($user->roles as $role)
                        <span class="badge bg-primary me-1">{{ $role->name }}</span>
                    @empty
                        <span class="text-muted">Žádné role</span>
                    @endforelse
                </div>

                <h6>Přímá oprávnění:</h6>
                <div class="mb-3">
                    @forelse($user->permissions as $permission)
                        <span class="badge bg-success me-1">{{ $permission->name }}</span>
                    @empty
                        <span class="text-muted">Žádná přímá oprávnění</span>
                    @endforelse
                </div>

                <h6>Všechna oprávnění (včetně z rolí):</h6>
                <div>
                    @forelse($user->getAllPermissions() as $permission)
                        <span class="badge bg-info me-1 mb-1">{{ $permission->name }}</span>
                    @empty
                        <span class="text-muted">Žádná oprávnění</span>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Edit Permissions Modal -->
<div class="modal fade" id="editPermissionsModal" tabindex="-1" aria-labelledby="editPermissionsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('users.update', $user) }}">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h5 class="modal-title" id="editPermissionsModalLabel">
                        Upravit oprávnění - {{ $user->name }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Role:</h6>
                            @foreach($roles as $role)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->name }}"
                                           id="role_{{ $role->id }}" {{ $user->hasRole($role->name) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="role_{{ $role->id }}">
                                        {{ $role->name }}
                                        <small class="text-muted">({{ $role->permissions->pluck('name')->join(', ') }})</small>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        {{--
                        <div class="col-md-6">
                            <h6>Přímá oprávnění:</h6>
                            @foreach($permissions as $permission)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                           id="permission_{{ $permission->id }}" {{ $user->hasDirectPermission($permission->name) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="permission_{{ $permission->id }}">
                                        {{ $permission->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                         --}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zrušit</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-shield-check"></i> Uložit oprávnění
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection
