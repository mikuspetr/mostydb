@extends('templates.main')
@section('content')
    <x-crud.header>Úprava klienta {{$client->clientCode}}</x-crud.header>
    @include('forms.client-form')
@endsection

@push('scripts')
    @include('forms.client-form-js')
@endpush
