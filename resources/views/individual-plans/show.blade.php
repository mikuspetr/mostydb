@extends('templates.main')
@section('content')
    <x-crud.header itemId="{{$plan->id}}">IP č. {{ $plan->id }}</x-crud.header>
    <div class="row">
        <div class="col-sm-10">
            <x-session-alert></x-session-alert>
            <x-ip-card :ip="$plan" />

    </div>
@endsection

