@extends('templates.main')
@section('content')

<h1>Přehled klientů podle obcí</h1>
<form>
    <div class="row">
        <div class="col-sm-2">
            <label for="from" class="form-label mt-0">Od</label>
            <input type="date" name="from" id="from" value="{{$request->from}}" class="form-control">
        </div>
        <div class="col-sm-2">
            <label for="to" class="form-label mt-0">Do</label>
            <input type="date" name="to" id="to" value="{{$request->to}}" class="form-control">
        </div>
        <div class="col-sm-2">
            <br>
            <button type="submit" class="btn btn-outline-primary">Nastavit</button>
        </div>
    </div>
</form>
<hr>
    <div class="row">
        <div class="col-sm-4">
            <table class="table">
                <tr><th>Obec</th><th>Počet klientů</th></tr>
                @foreach($municipalities as $municipality => $count)
                <tr><td>{{$municipality}}</td><td>{{$count}}</td></tr>
                @endforeach
            </table>
        </div>
        <div class="col-sm-4 sm-offset-1">
            <table class="table">
                <tr><th>ORP</th><th>Počet klientů</th></tr>
                @foreach($orps as $orp => $count)
                <tr><td>{{$orp}}</td><td>{{$count}}</td></tr>
                @endforeach
            </table>
        </div>
        <div class="col-sm-4">
            <h3>Nazařazení klienti - chybí obec</h3>
            @foreach($noMunClients as $client)
            <p class="mb-1">{{$client->clientCode}}</p>
            @endforeach
        </div>
    </div>


@endsection
