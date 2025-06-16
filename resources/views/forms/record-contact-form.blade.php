<form method="POST" action="{{ route('records.store') }}">
    @csrf
    <div class="row">
        <div class="col-sm-3">
            <label for="date" class="form-label mt-0">Datum</label>
            <input type="date" name="date" value="{{ isset($record) ? $record->date : date('Y-m-d')}}" id="date" class="form-control" required>

            <label class="form-label">Místo</label><br>
            @foreach ($places as $place)
                <label class="{{ $loop->first ? '' : 'ms-3' }}">
                    <input type="radio" name="place_id" value="{{ $place->id }}" class="form-check-input"
                        {{ (isset($record) && $record->place_id == $place->id) || $loop->first ? 'checked' : '' }}>
                    {{ $place->name }}
                </label>
            @endforeach
            <br>

            <label for="clients" class="form-label">Klient</label>
            <select name="clients[]" id="clients" class="form-select">
                @foreach ($clients as $client)
                    <option value="{{ $client->id }}" {{ isset($record) && $record->hasClientId($client->id) ? 'selected' : '' }}>{{ $client->clientCode }}</option>
                @endforeach
            </select>
            <label for="users" class="form-label">Pracovník</label>
            <select name="users[]" id="users" class="form-select">
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ isset($record) && $record->hasUserId($user->id) ? 'selected' : '' }}>{{ $user->login }}</option>
                @endforeach
            </select>
            <br>
            <hr>
            <div class="row">
                <div class="col">
                    <label for="duration" class="form-label">Čas kontaktu</label>
                    <select name="duration" id="duration" class="form-select">
                        @foreach($kontaktDurations as $value => $duration)
                            <option value="{{$value}}" {{ isset($record) && $record->duration == $value ? 'selected' : '' }}>
                                {{$duration}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label for="duration_pp" class="form-label">Čas přímé péče</label>
                    <select name="duration_pp" id="duration_pp" class="form-select">
                        @foreach($kontaktDurations as $value => $duration)
                            <option value="{{$value}}" {{ isset($record) && $record->duration_pp == $value ? 'selected' : '' }}>
                                {{$duration}}
                            </option>
                        @endforeach
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
                    {{ !isset($record->color_id) || $record->color_id === null ? 'checked' : '' }}>
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
        <div class="col-sm-8">
            <label for="text">Text kontaktu</label>
            <textarea name="text" id="text" class="ckeditor">{{ isset($record) ? $record->text : '' }}</textarea>
        </div>
        <div class="col-sm-4">

        </div>
    </div>
    <input type="hidden" name="kind_id" value="4">
    <input type="hidden" name="intervention" value="0">
    <button type="submit" class="btn btn-primary mt-3">{{isset($record) ? 'Upravit kontakt' : 'Přidat kontakt' }}</button>
</form>
