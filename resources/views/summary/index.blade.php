@extends('templates.main')
@section('content')

<div class="row">
    <div class="col-10">
        <h1 class="mt-3">Přehledy za rok {{ $year }}</h1>
    </div>
    <div class="col-2">
        <form method="GET" action="{{ route('summary.index') }}">
            <div class="form-group">
                <label for="year">Vyberte rok:</label>
                <select name="year" id="year" class="form-control" onchange="this.form.submit()">
                    @for ($i = date('Y'); $i >= 2014; $i--)
                        <option value="{{ $i }}" {{ $i == $year ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>
        </form>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-3">
        <h3>Plnění plánu - čas intervencí</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Měsíc</th>
                    <th>Čas</th>
                    <th>Plán</th>
                    <th>Splněno</th>
                </tr>
            </thead>

            @foreach($months as $month)
            <tr>
                <td>{{ $month['name'] }}</td>
                <td>{{ $month['duration'] }}</td>
                <td>{{ $month['plan'] }}</td>
                <td>{{ round($month['duration']/$month['plan'], 2) * 100 }}%</td>
            </tr>
            @endforeach

        </table>
    </div>

    <div class="col offset-1">
        <h3>Přehled ukazatelů za rok {{ $year }}</h3>
        @include('summary.__placeOverview', ['overview' => $allPlaces])

        <h3 class="mt-4">Přehled ukazatelů pro Vsetín</h3>
        @include('summary.__placeOverview', ['overview' => $vsetin])

        <h3 class="mt-4">Přehled ukazatelů pro ValMez</h3>
        @include('summary.__placeOverview', ['overview' => $valmez])
    </div>

    <div class="col offset-1">
        <h3>Přehled setkání podle času</h3>
        <table class="table">
            <thead>
                <tr>
                    <th></th>
                    <th>Matematicky</th>
                    <th>Samostatně</th>
                </tr>
            </thead>
            @foreach($meetings as $row)
            <tr>
                <td>{{ $row['name'] }}</td>
                <td>{{ $row['count'] }}</td>
                <td>{{ $row['unique'] }}</td>
            </tr>
            @endforeach
    </div>
</div>
@endsection
