<form action="{{ isset($role) ? route('roles.update', [$role->id]) : route('roles.store') }}" method="POST">
    @csrf
    @if(isset($role))
        @method('PUT')
    @endif
    <div class="modal-body">
        <div class="mb-3">
            <label for="roleName" class="form-label">Název</label>
            <input type="text" class="form-control" id="roleName" name="name" required value="{{ isset($role) ? $role->name : '' }}">
        </div>
    </div>
    <div class="modal-body">
        <div class="mb-3">
            <label class="form-label">Oprávnění</label>
            <div class="form-check">
                @foreach($permissions as $permission)
                <input class="form-check-input" type="checkbox" name="permissions[]" value="{{$permission->name}}" id="permission{{$permission->id}}" {{ isset($role) && $role->permissions->contains('id', $permission->id) ? 'checked' : '' }}>
                <label class="form-check-label" for="permission{{$permission->id}}">
                    {{$permission->name}}
                </label><br>
                @endforeach
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">{{ isset($role) ? 'Upravit' : 'Vytvořit' }}</button>
</form>
