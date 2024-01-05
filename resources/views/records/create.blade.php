@extends('templates.main')
@section('content')
    <x-crud.header>Nový záznam</x-crud.header>

    <form method="POST" action="{{ route('records.create') }}">
        <div class="row">
            <div class="col-sm-2">
                <label for="date" class="form-label">Datum</label>
                <input type="date" name="date" id="date" class="form-control">
                <br>
                <label><input type="radio" name="place" value="1" class="form-check-input"> Vsetín</label>
                <label><input type="radio" name="place" value="2" class="form-check-input"> Val.Mez.</label>
                <label><input type="radio" name="place" value="3" class="form-check-input"> Jinde</label>
                <br>
                <label for="client" class="form-label">Klient</label>
                <select name="client" id="client" class="form-select">
                    @foreach ($clients as $id => $code)
                        <option value="{{ $id }}">{{ $code }}</option>
                    @endforeach
                </select>
                <label for="user" class="form-label">Pracovník</label>
                <select name="user" id="user" class="form-select">
                    @foreach ($users as $id => $login)
                        <option value="{{ $id }}">{{ $login }}</option>
                    @endforeach
                </select>
            </div>
        </div>

    </form>
@endsection
