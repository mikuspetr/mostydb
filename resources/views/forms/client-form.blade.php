<hr>
<form method="POST" action="{{ route('clients.store') }}">
    @csrf
    <div class="row">
        <div class="col-lg-10">
            <div class="row">
                <div class="col-sm-2">
                    <label>Uživatel / Zájemce</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="client_status" id="client-user" value="1"
                            checked>
                        <label class="form-check-label" for="client-user">
                            Uživatel
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="client_status" id="client-entrant" value="2">
                        <label class="form-check-label" for="client-entrant">
                            Zájemce
                        </label>
                    </div>
                </div>
                <div class="col-sm-2">
                    <label for="code" class="form-label">Kód uživatele</label>
                    <input type="text" name="code" id="code" class="form-control" maxlength="6" required onkeyup="this.value = this.value.toUpperCase();">
                </div>
                <div class="col-sm-2">
                    <label>Pohlaví</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sex_id" id="sex-male" value="1"
                            checked>
                        <label class="form-check-label" for="sex-male">
                            Muž
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sex_id" id="sex-female" value="2">
                        <label class="form-check-label" for="sex-female">
                            Žena
                        </label>
                    </div>
                </div>
                <div class="col-sm-2">
                    <label>Zařazení</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="type_id" id="neurotic" value="2"
                            checked>
                        <label class="form-check-label" for="neurotic">
                            Neurózy
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="type_id" id="adicted" value="1">
                        <label class="form-check-label" for="adicted">
                            Závislosti
                        </label>
                    </div>
                </div>
                <div class="col-sm-2">
                    <label for="contract" class="form-label">Datum</label>
                    <input type="date" name="contract" id="contract" class="form-control">
                </div>
                <div class="col-sm-2">
                    <label for="orp" class="form-label">ORP:</label>
                    <select name="orp_id" id="orp" class="form-select">
                        @foreach ($regions as $region)
                        <option value="{{$region->id}}" {{$region->id == \App\Models\Address\OrpRegion::VSETIN_ORP_ID ? 'selected' : ''}}>
                            {{$region->name}}
                        </option>
                        @endforeach
                    </select>
                    <label for="municipality" class="form-label">Obec</label>
                    <select name="municipality_id" id="municipality" class="form-select">
                        <option value="">Vyberte obec</option>
                        @foreach ($municipalities as $municipality)
                        <option value="{{$municipality->id}}" {{$municipality->id == \App\Models\Address\Municipality::VSETIN_ID ? 'selected' : ''}}>
                            {{$municipality->name}}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <h5>Anamnéza</h5>
        <div class="col-sm-4">
            <label for="first-contact" class="form-label">První kontak</label>
            <textarea name="first_contact" id="first-contact" class="form-control" rows="5"></textarea>
        </div>
        <div class="col-sm-4">
            <label for="personal" class="form-label">Osobní</label>
            <textarea name="personal" id="personal" class="form-control" rows="5"></textarea>
        </div>
        <div class="col-sm-4">
            <label for="social" class="form-label">Sociální</label>
            <textarea name="social" id="social" class="form-control" rows="5"></textarea>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Přidat klienta</button>
</form>
