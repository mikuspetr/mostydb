@extends('templates.main')
@section('content')
    <x-crud.header itemId="{{$role->id}}">Detail role {{$role->name}}</x-crud.header>
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Název role</h5>
            <p class="card-text">{{$role->name}}</p>
            <h5 class="card-title">Oprávnění</h5>
            <p class="card-text">
                @foreach($role->permissions as $permission)
                    <span class="badge bg-secondary">{{$permission->name}}</span>
                @endforeach
            </p>
        </div>
    </div>
@endsection
