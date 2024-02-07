@extends('templates.main')
@section('content')
<x-crud.header>Úprava záznamu č. {{$record->id}}</x-crud.header>
<div class="row">
    @switch($record->kind_id)
        @case(1)
            @include('forms.record-individual-form')
            @break
        @case(2)
            @include('forms.record-group-form')
            @break
        @case(4)
            @include('forms.record-contact-form')
            @break
        @default
    @endswitch

</div>
@endsection

