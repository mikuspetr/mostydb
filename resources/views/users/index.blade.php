@extends('templates.main')
@section('content')
<div class="row">
    <x-crud.header>Pracovníci</x-crud.header>
    <table class="table">
        <thead><tr><th>#</th><th>jméno</th><th>Email</th><th>Role</th></tr></thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>
                    {{$user->id}}
                    {{--
                    @if(Auth::user()->hasRole('admin'))
                    <a class="btn btn-outline-primary btn-xs" href="{{route('users.edit', ['user' => $user->id])}}" title="upravit"><i class="bi bi-pencil-square"></i></a>
                    @endif
                     --}}
                    <a class="btn btn-outline-primary btn-xs" href="{{route('users.show', ['user' => $user->id])}}" title="zobrazit"><i class="bi bi-pencil"></i></a>
                </td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>{{ implode(', ', $user->getRoleNames()->toArray()) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="row">
    <div class="crud-header">
        <h2 class="crud-header__title">Role</h2>
        <a class="btn btn-outline-success crud-header__button" href="{{ route('roles.create') }}">
            <i class="bi bi-plus"></i>
            Vytvořit roli
        </a>
    </div>

    @include('roles.roles-table', ['roles' => $roles])
</div>
@endsection
