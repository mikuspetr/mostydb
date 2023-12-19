@extends('templates.main')

@section('content')
<x-nav-resources />
<h1>Klienti</h1>
<table class="table">
    <thead><tr><td>#</td><td>Kód</td></tr></thead>
    <tbody>
        @foreach($clients as $client)
        <tr>
            <td>
                {{$client->id}}
                <a class="btn btn-outline-primary btn-sm" href="{{route('clients.edit', ['client' => $client->id])}}" title="upravit"><i class="bi bi-pencil-square"></i></a>
                <a class="btn btn-outline-primary btn-sm" href="{{route('clients.show', ['client' => $client->id])}}" title="zobrazit"><i class="bi bi-eye"></i></a>
            </td>
            <td>{{$client->clientCode}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
{!! $clients->links() !!}
@endsection
