@extends('templates.main')
@section('content')
    <div class="row">
        <div class="col-sm-10">
            <x-session-alert></x-session-alert>
            <h2 class="my-4">Detail záznamu č. {{ $record->id }} </h2>
            <x-record-card :record="$record" />

    </div>
@endsection

