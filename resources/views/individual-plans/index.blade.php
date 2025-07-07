@extends('templates.main')

@section('content')
@if(session('info'))
    <x-info-modal :message="session('info')" />
@endif
<x-crud.header>Individuální plány</x-crud.header>

<hr>
<div class="col col-xxl-5 crud-filters">
    <form method="GET" action="{{ route('individual-plans.index') }}">
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
                <label for="date_from" class="form-label">Od</label>
                <input type="date" name="date_from" id="date_from" class="form-control" value="{{ old('date_from', $dateFrom ?? '') }}">
            </div>
            <div class="col">
                <label for="date_to" class="form-label">Do</label>
                <input type="date" name="date_to" id="date_to" class="form-control" value="{{ old('date_to', $dateTo ?? '') }}">
            </div>
            <div class="col-auto align-self-end">
                <button type="submit" class="btn btn-primary btn-small">Filtrovat</button>
                <a href="{{ route('individual-plans.index') }}" class="btn btn-secondary">Zrušit</a>
            </div>
        </div>
    </form>
</div>
<hr>
{!! $plans->links() !!}

<table class="table align-middle">
    <thead>
        <tr>
            <th>#</th>
            <th class="crud-action-column">
                <a href="{{ route('individual-plans.index', array_merge(request()->except('page'), ['sort' => 'date', 'direction' => request('sort') === 'date' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
                    Datum
                    @if(request('sort') === 'date')
                        <i class="bi bi-caret-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                    @endif
                </a>
            </th>
            <th>
                Klient
            </th>
            <th>
                Nadpis
            </th>
            <th>Text</th>
        </tr>
    </thead>

    <tbody>
        @foreach($plans as $plan)
        <tr>
            <td>
                {{$plan->id}}<br>
                <a class="btn btn-outline-primary btn-xs" href="{{route('individual-plans.edit', ['individual_plan' => $plan->id])}}" title="upravit"><i class="bi bi-pencil-square"></i></a>
                <a class="btn btn-outline-primary btn-xs" href="{{route('individual-plans.show', ['individual_plan' => $plan->id])}}" title="zobrazit"><i class="bi bi-eye"></i></a>
                <form method="POST" action="{{route('individual-plans.destroy', ['individual_plan' => $plan->id])}}" onsubmit="return confirm('Opravdu chcete záznam smazat?');" style="display:inline;">
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-outline-primary btn-xs" title="smazat"><i class="bi bi-trash"></i></button>
                </form>
                 
            </td>
            <td>{{$plan->datum}}</td>
            <td>
                {{$plan->client->clientCode ?? ''}}
            </td>
            <td>{{$plan->title ?? ''}}</td>
            <td><div class="record-text">{!!$plan->text !!}</div></td>
        </tr>
        @endforeach
    </tbody>
</table>
{!! $plans->links() !!}

@endsection
