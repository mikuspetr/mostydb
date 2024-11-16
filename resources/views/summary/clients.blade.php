@extends('templates.main')
@section('content')

<div class="row">
    <div class="col-sm-6">
        <h1 class="mt-3">Přehled klientů podle obcí</h1>
    </div>
    <div class="col-sm-1 border-end border-start">
        <form method="GET" action="{{ route('summary.clients') }}">
            <div class="row">
                <div class="col-sm-12">
                    <label for="year" class="form-label mt-0">Rok</label>
                    <select name="year" id="year" class="form-control">
                        @for($i = date('Y'); $i >= 2014; $i--)
                            <option value="{{$i}}" {{$i == substr($request->from, 0, 4) ? 'selected' : ''}}>{{$i}}</option>
                        @endfor
                    </select>
                </div>
            </div>
        </form>
    </div>
    <div class="col-sm-4 offset-1">
        <form>
            <div class="row">
                <div class="col-sm-5">
                    <label for="from" class="form-label mt-0">Od</label>
                    <input type="date" name="from" id="from" value="{{$request->from}}" class="form-control">
                </div>
                <div class="col-sm-5">
                    <label for="to" class="form-label mt-0">Do</label>
                    <input type="date" name="to" id="to" value="{{$request->to}}" class="form-control">
                </div>
                <div class="col-sm-2 mt-4">
                    <button type="submit" class="btn btn-outline-primary">Nastavit</button>
                </div>
            </div>
        </form>
    </div>
</div>
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


@push('scripts')
    <script>
        $(document).ready(function () {
            console.log('ready');
            $('#year').change(function() {
                var selectedYear = $(this).val();
                var url = "{{ route('summary.clients') }}";
                window.location.href = url + '?from=' + selectedYear + '-01-01&to=' + selectedYear + '-12-31';
            });
        });
    </script>
@endpush
