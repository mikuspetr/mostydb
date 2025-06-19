@extends('templates.main')

@section('content')
@if(session('info'))
    <x-info-modal :message="session('info')" />
@endif
<x-crud.header>Záznamy</x-crud.header>

<hr>
<div class="col col-xxl-9 crud-filters">
    <form method="GET" action="{{ route('records.index') }}">
        <div class="row g-2">
            <div class="col">
                <label for="client_id" class="form-label">Klient</label>
                <select name="client_id" id="client_id" class="form-select">
                <option value="">-- Všichni --</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" {{ (old('client_id', $clientId ?? '') == $client->id) ? 'selected' : '' }}>
                    {{ $client->clientCode }}
                    </option>
                @endforeach
                </select>
            </div>
            <div class="col">
                <label for="user_id" class="form-label">Pracovník</label>
                <select name="user_id" id="user_id" class="form-select">
                <option value="">-- Všichni --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ (old('user_id', $userId ?? '') == $user->id) ? 'selected' : '' }}>
                    {{ $user->login }}
                    </option>
                @endforeach
                </select>
            </div>
            <div class="col">
                <label for="place_id" class="form-label">Místo</label>
                <select name="place_id" id="place_id" class="form-select">
                <option value="">-- Všechna --</option>
                @foreach($places as $place)
                    <option value="{{ $place->id }}" {{ (old('place_id', $placeId ?? '') == $place->id) ? 'selected' : '' }}>
                    {{ $place->name }}
                    </option>
                @endforeach
                </select>
            </div>
            <div class="col">
                <label for="type_id" class="form-label">Typ</label>
                <select name="type_id" id="type_id" class="form-select">
                <option value="">-- Všechny --</option>
                @foreach($types as $type)
                    <option value="{{ $type->id }}" {{ (old('type_id', $typeId ?? '') == $type->id) ? 'selected' : '' }}>
                    {{ $type->name }}
                    </option>
                @endforeach
                </select>
            </div>
            <div class="col">
                <label for="kind_id" class="form-label">Druh</label>
                <select name="kind_id" id="kind_id" class="form-select">
                <option value="">-- Všechny --</option>
                @foreach($kinds as $kind)
                    <option value="{{ $kind->id }}" {{ (old('kind_id', $kindId ?? '') == $kind->id) ? 'selected' : '' }}>
                    {{ $kind->name }}
                    </option>
                @endforeach
                </select>
            </div>
            
            <div class="col">
                <label for="color_id" class="form-label">Barva záznamu</label>
                <select name="color_id" id="color_id" class="form-select">
                    <option value="">-- Všechny --</option>
                    @foreach($recordColors as $color)
                        <option value="{{ $color->id }}" {{ (old('color_id', $colorId ?? '') == $color->id) ? 'selected' : '' }}>
                            {{ $color->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col">
                <label for="date_from" class="form-label">Od</label>
                <input type="date" name="date_from" id="date_from" class="form-control" value="{{ old('date_from', $dateFrom ?? '') }}">
            </div>
            <div class="col">
                <label for="date_to" class="form-label">Do</label>
                <input type="date" name="date_to" id="date_to" class="form-control" value="{{ old('date_to', $dateTo ?? '') }}">
            </div>
            <div class="col-auto align-self-end">
                <button type="submit" class="btn btn-primary btn-small">Filtrovat</button>
                <a href="{{ route('records.index') }}" class="btn btn-secondary">Zrušit</a>
            </div>
        </div>
    </form>
</div>
<hr>
{!! $records->links() !!}

<table class="table align-middle">
    <thead>
        <tr>
            <th class="crud-action-column">
                <a href="{{ route('records.index', array_merge(request()->except('page'), ['sort' => 'id', 'direction' => request('sort') === 'id' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
                    #
                    @if(request('sort') === 'id')
                        <i class="bi bi-caret-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                    @endif
                </a>
            </th>
            <th class="sorting-column">
                <a href="{{ route('records.index', array_merge(request()->except('page'), ['sort' => 'date', 'direction' => request('sort') === 'date' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
                    Datum
                    @if(request('sort') === 'date')
                        <i class="bi bi-caret-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                    @endif
                </a>
            </th>
            <th>
                Místo
            </th>
            <th>
                Pracovník
            </th>
            <th>
                Klient
            </th>
            <th>
                Forma
            </th>
            <th>
                Typ
            </th>
            <th>
                <a href="{{ route('records.index', array_merge(request()->except('page'), ['sort' => 'duration', 'direction' => request('sort') === 'duration' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
                    Délka
                    @if(request('sort') === 'duration')
                        <i class="bi bi-caret-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                    @endif
                </a>
            </th>
            <th>Text</th>
        </tr>
    </thead>

    <tbody>
        @foreach($records as $record)
        <tr class="text-{{ $record->bootstrapColorClass }}">
            <td>
                {{$record->id}}<br>
                <a class="btn btn-outline-primary btn-xs" href="{{route('records.edit', ['record' => $record->id])}}" title="upravit"><i class="bi bi-pencil-square"></i></a>
                <a class="btn btn-outline-primary btn-xs" href="{{route('records.show', ['record' => $record->id])}}" title="zobrazit"><i class="bi bi-eye"></i></a>
                <form method="POST" action="{{route('records.destroy', ['record' => $record->id])}}" onsubmit="return confirm('Opravdu chcete záznam smazat?');" style="display:inline;">
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-outline-primary btn-xs" title="smazat"><i class="bi bi-trash"></i></button>
                </form>
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
