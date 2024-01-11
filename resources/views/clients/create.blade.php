@extends('templates.main')
@section('content')
    <x-crud.header btnText='Přehled kientů'>Přidat nového klienta</x-crud.header>
    @include('forms.client-form')
@endsection

@push('scripts')
    @include('forms.client-form-js')
@endpush
