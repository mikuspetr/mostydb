@extends('templates.main')
@section('content')
@foreach($clients as $client)

<p>{{$client->clientCode}}</p>
@endforeach
@endsection
