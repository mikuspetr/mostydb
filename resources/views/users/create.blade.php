@extends('templates.main')
@section('content')
    <x-crud.header>Nový pracovník</x-crud.header>
    @include('forms.user-form')
@endsection
