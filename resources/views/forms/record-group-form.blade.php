<form method="POST" action="{{ route('records.store') }}">
    @csrf
    <div class="row">
        <div class="col-sm-3">
            <label for="date" class="form-label mt-0">Datum</label>
            <input type="date" name="date" id="date" class="form-control" required>

            <label class="form-label">Místo</label><br>
            <label><input type="radio" name="place" value="1" class="form-check-input" checked> Vsetín</label>
            <label class="ms-3"><input type="radio" name="place" value="2" class="form-check-input">
                Val.Mez.</label>
            <label class="ms-3"><input type="radio" name="place" value="3" class="form-check-input">
                Jinde</label>
            <br>
            <label for="client" class="form-label">Klienti</label>
            <select name="clients[]" id="client" class="form-select" multiple>
                @foreach ($clients as $client)
                    <option value="{{ $client->id }}"  {{ isset($record) && $record->hasClientId($client->id) ? 'selected' : '' }}>
                        {{ $client->clientCode }}
                    </option>
                @endforeach
            </select>
            <label for="user" class="form-label">Pracovníci</label>
            <select name="users[]" id="user" class="form-select" multiple>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ isset($record) && $record->hasUserId($user->id) ? 'selected' : '' }}>
                        {{ $user->login }}
                    </option>
                @endforeach
            </select>
            <br>
            <hr>
            <div class="row">
                <div class="col">
                    <label for="duration" class="form-label">Čas intervence</label>
                    <select name="duration" id="duration" class="form-select">
                        <option value="10">10 min</option>
                        <option value="20">20 min</option>
                        <option value="30">30 min</option>
                    </select>
                </div>
                <div class="col">
                    <label for="duration_pp" class="form-label">Čas přímé péče</label>
                    <select name="duration_pp" id="duration_pp" class="form-select">
                        <option value="10">10 min</option>
                        <option value="20">20 min</option>
                        <option value="30">30 min</option>
                    </select>
                </div>
            </div>

            <label class="form-label">Forma intervence</label><br>
            @foreach ($recordForms as $form)
                <label class="{{ $loop->first ? '' : 'ms-3' }}">
                    <input type="radio" name="form_id" value="{{ $form->id }}" class="form-check-input"
                        {{ (isset($record) && $record->form_id == $form->id) || $loop->first ? 'checked' : '' }}>
                    {{ $form->name }}
                </label>
            @endforeach
            <br>

            <label class="form-label">Typ intervence</label><br>
            @foreach ($recordTypes as $type)
                <label class="{{ $loop->first ? '' : 'ms-3' }}">
                    <input type="radio" name="type_id" value="{{ $type->id }}" class="form-check-input"
                        {{ (isset($record) && $record->type_id == $type->id) || $loop->first ? 'checked' : '' }}>
                    {{ $type->name }}
                </label>
            @endforeach
            <br>

            <label class="form-label">Označení ve výpisu</label><br>
            <label>
                <input type="radio" name="status_id" value="" class="form-check-input"
                    {{ !isset($record->color_id) ? 'checked' : '' }}>
                Žádné
            </label>
            @foreach ($recordColors as $color)
                <label class="ms-3" style="color:{{ $color->color }}">
                    <input type="radio" name="color_id" value="{{ $color->id }}" class="form-check-input"
                        {{ isset($record) && $record->color_id == $color->id ? 'checked' : '' }}>
                    {{ $color->name }}
                </label>
            @endforeach
            <br>
        </div>
        <div class="col-sm-5">
            <label for="text">Text intervence</label>
            <textarea name="text" id="text" class="ckeditor"></textarea>
        </div>
        <div class="col-sm-4">

        </div>
    </div>
    <input type="hidden" name="kind_id" value="2">
    <input type="hidden" name="intervention" value="1">
    <button type="submit" class="btn btn-primary">Přidat záznam</button>
</form>
