@extends('templates.main')
@section('content')
    <x-crud.header>Úprava role {{$role->name}}</x-crud.header>
    @include('forms.role-form', ['role' => $role])
@endsection
