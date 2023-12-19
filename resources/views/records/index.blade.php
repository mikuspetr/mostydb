@extends('templates.main')

@section('content')
<h1>Klienti</h1>
<table class="table">
    <thead><tr><td>#</td><td>Datum</td><td>Místo</td><td>Pracovník</td><td>Klient</td><td>Forma</td><td>Typ</td><td>Délka</td><td>Text</td></tr></thead>
    <tbody>
        @foreach($records as $record)
        <tr>
            <td>
                <a class="btn btn-outline-primary btn-sm" href="{{route('records.edit', ['record' => $record->id])}}">{{$record->id}}</a>
            </td>
            <td>{{$record->date}}</td>
            <td>{{$record->place->name ?? ''}}</td>
            <td>
                @foreach($record->users as $user)
                {{$user->login}}<br>
                @endforeach
            </td>
            <td>
                @foreach($record->clients as $client)
                {{$client->clientCode}}<br>
                @endforeach
            </td>
            <td>{{$record->form->name ?? ''}}</td>
            <td>{{isset($record->kind->name) ? $record->kind->name.', ' : ''}}{{$record->type->name ?? ''}}</td>
            <td>{{$record->duration}}</td>
            <td><div class="record-text">{!!$record->text !!}</div></td>
        </tr>
        @endforeach
    </tbody>
</table>
{!! $records->links() !!}
@endsection
