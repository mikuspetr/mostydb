@extends('templates.main')
@section('content')
<x-crud.header>Role</x-crud.header>
@include('roles.roles-table', ['roles' => $roles])

@endsection
