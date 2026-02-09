@extends('templates.main')
@section('content')
    <x-crud.header>Nová role</x-crud.header>
    @include('forms.role-form')
@endsection
