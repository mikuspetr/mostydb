<hr>
<form method="POST" action="{{ isset($client) ? route('clients.update', [$client->id]) : route('clients.store') }}">
    @csrf
    @if(isset($client))
    @method('PUT')
    @endif
    <div class="row">
        <div class="col-lg-10">
            <div class="row">
                <div class="col-sm-2">
                    <label>Uživatel / Zájemce</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="client_type" id="client-user" value="1"
                            {{ !isset($client) || $client->type === 'Uživatel' ? 'checked' : '' }}>
                        <label class="form-check-label" for="client-user">
                            Uživatel
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="client_type" id="client-entrant" value="2"
                            {{ isset($client) && $client->type === 'Zájemce' ? 'checked' : '' }}>
                        <label class="form-check-label" for="client-entrant">
                            Zájemce
                        </label>
                    </div>
                </div>
                <div class="col-sm-2">
                    <label for="code" class="form-label">Kód uživatele</label>
                    <input type="text" name="code" id="code" class="form-control" maxlength="6" required onkeyup="this.value = this.value.toUpperCase();"
                        value="{{$client->code ?? null}}">
                </div>
                <div class="col-sm-2">
                    <label>Pohlaví</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sex_id" id="sex-male" value="1"
                            {{ !isset($client) || $client->sex_id === 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="sex-male">
                            Muž
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sex_id" id="sex-female" value="2"
                            {{ isset($client) && $client->sex_id === 2 ? 'checked' : '' }}>
                        <label class="form-check-label" for="sex-female">
                            Žena
                        </label>
                    </div>
                </div>
                <div class="col-sm-2">
                    <label>Zařazení</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="category_id" id="neurotic" value="2"
                            {{ !isset($client) || $client->category_id === 2 ? 'checked' : '' }}>
                        <label class="form-check-label" for="neurotic">
                            Neurózy
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="category_id" id="adicted" value="1"
                            {{ isset($client) && $client->category_id === 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="adicted">
                            Závislosti
                        </label>
                    </div>
                </div>
                <div class="col-sm-2">
                    <label for="contract" class="form-label">Datum</label>
                    <input type="date" name="contract" id="contract" class="form-control" value="{{$client->contract ?? null}}"
                        {{ isset($client) && $client->type === 'Zájemce' ? 'disabled' : '' }}>
                </div>
                <div class="col-sm-2">
                    <label for="orp" class="form-label">ORP:</label>
                    <select name="orp_id" id="orp" class="form-select">
                        <option value="1">Vyberte ORP</option>
                        @foreach ($regions as $region)
                        <option value="{{$region->id}}" {{ isset($client->municipality_id) && $client->municipality->orp_region_id == $region->id ? 'selected' : ''}}>
                            {{$region->name}}
                        </option>
                        @endforeach
                    </select>
                    <label for="municipality" class="form-label mt-3">Obec</label>
                    <select name="municipality_id" id="municipality" class="form-select">
                        <option value="">
                            {{$municipalities->count() > 0 ? 'Vyberte obec' : 'Nejprve vyberte ORP'}}
                        </option>
                        @foreach ($municipalities as $municipality)
                        <option value="{{$municipality->id}}" {{ isset($client->municipality_id) && $client->municipality_id == $municipality->id ? 'selected' : ''}}>
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
            <textarea name="first_contact" id="first-contact" class="form-control ckeditor" rows="5">
                {{$client->description->first_contact ?? null}}
            </textarea>
        </div>
        <div class="col-sm-4">
            <label for="personal" class="form-label">Osobní</label>
            <textarea name="personal" id="personal" class="form-control ckeditor" rows="5">
                {{$client->description->personal ?? null}}
            </textarea>
        </div>
        <div class="col-sm-4">
            <label for="social" class="form-label">Sociální</label>
            <textarea name="social" id="social" class="form-control ckeditor" rows="5">
                {{$client->description->social ?? null}}
            </textarea>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Přidat klienta</button>
</form>
