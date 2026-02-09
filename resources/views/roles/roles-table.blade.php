<table class="table">
    <thead><tr><th>#</th><th>název</th><th>Oprávnění</th><th>Použito</th></tr></thead>
    <tbody>
    @foreach($roles as $role)
    <tr>
        <td>
            {{$role->id}}
            <a class="btn btn-outline-primary btn-xs" href="{{route('roles.edit', ['role' => $role->id])}}" title="upravit"><i class="bi bi-pencil-square"></i></a>
            @if($role->users()->count() == 0)
            <form method="POST" action="{{route('roles.destroy', ['role' => $role->id])}}" onsubmit="return confirm('Opravdu chcete roli {{$role->name}} smazat?');" style="display:inline;">
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-outline-primary btn-xs" title="smazat"><i class="bi bi-trash"></i></button>
                </form>
            @endif
        </td>
        <td>{{$role->name}}</td>
        <td>{{ implode(', ', $role->permissions->pluck('name')->toArray()) }}</td>
        <td>{{ $role->users()->count() }} <i class="bi bi-people" title="{{ implode(', ', $role->users->pluck('name')->toArray()) }}"></i></td>
    </tr>
    @endforeach
    </tbody>
</table>
