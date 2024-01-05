@extends('templates.main')
@section('content')
<x-crud.header>Pracovníci</x-crud.header>
<table class="table">
    <thead><tr><td>#</td><td>jméno</td><td>Email</td><td>Role</td></tr></thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>
                {{$user->id}}
                @if(Auth::user()->hasPermissionTo('edit users'))
                <a class="btn btn-outline-primary btn-sm" href="{{route('users.edit', ['user' => $user->id])}}" title="upravit"><i class="bi bi-pencil-square"></i></a>
                @endif
                <a class="btn btn-outline-primary btn-sm" href="{{route('users.show', ['user' => $user->id])}}" title="zobrazit"><i class="bi bi-eye"></i></a>
            </td>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
            <td>{{ implode(', ', $user->getRoleNames()->toArray()) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
