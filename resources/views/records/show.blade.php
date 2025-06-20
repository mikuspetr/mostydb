@extends('templates.main')
@section('content')
    <x-crud.header itemId="{{$record->id}}">Detail záznamu č. {{ $record->id }}</x-crud.header>
    <div class="row">
        <div class="col-sm-10">
            <x-session-alert></x-session-alert>
            <x-record-card :record="$record" />

    </div>
@endsection

