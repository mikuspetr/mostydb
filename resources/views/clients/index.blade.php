@extends('templates.main')

@section('content')
    <x-crud.header>Klienti</x-crud.header>
    <div class="row">
        <div class="col-sm-6">
            <form method="GET" action="{{ route('clients.index') }}" id="filtr">
                <div class="form-check">
                    <input class="form-check-input " type="checkbox" value="1" id="active_complaint"
                        name="active_complaint" {{ isset($request->active_complaint) ? 'checked' : '' }}>
                    <label class="form-check-label" for="active_complaint">
                        S aktivní smlouvou
                    </label>
                </div>
            </form>
        </div>
        <div class="col-sm-6">
            {!! $clients->links() !!}
        </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Kód</th>
                <th>Smlouva</th>
                <th>Obec</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clients as $client)
                <tr>
                    <td>
                        {{ $client->id }}
                        <a class="btn btn-outline-primary btn-sm"
                            href="{{ route('clients.edit', ['client' => $client->id]) }}" title="upravit"><i
                                class="bi bi-pencil-square"></i></a>
                        <a class="btn btn-outline-primary btn-sm"
                            href="{{ route('clients.show', ['client' => $client->id]) }}" title="zobrazit"><i
                                class="bi bi-eye"></i></a>
                    </td>
                    <td>{{ $client->clientCode }}</td>
                    <td>{{ $client->contractDate }} {{ $client->hasValidContract ? '- aktivní' : '' }}</td>
                    <td>{{ $client->munOrp }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {!! $clients->links() !!}
@endsection

@push('scripts')
    <script>
        $(document).on('click', 'input[name=active_complaint]', function() {
            $('#filtr').submit();
            console.log('sumb');
        });
    </script>
@endpush
