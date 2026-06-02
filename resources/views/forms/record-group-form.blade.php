<form method="POST" action="{{ isset($record) ? route('records.update', [$record->id]) : route('records.store') }}">
    @csrf
    @if(isset($record))
    @method('PUT')
    @endif
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

            <label for="clients" class="form-label">Klienti</label>

            <select name="clients[]" id="clients" class="form-select" multiple>
                @foreach ($clients as $client)
                    <option value="{{ $client->id }}" {{ isset($record) && $record->hasClientId($client->id) ? 'selected' : '' }}>{{ $client->clientCode }}</option>
                @endforeach
            </select>

            <button type="button" class="btn btn-outline-secondary mt-3 me-2" data-bs-toggle="modal" data-bs-target="#clientsModal">
                Vybrat klienty
            </button>
            <br>
            <label for="users" class="form-label">Pracovníci</label>
            <select name="users[]" id="users" class="form-select" multiple>
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
                        @foreach($groupDurations as $value => $duration)
                            <option value="{{$value}}" {{ isset($record) && $record->duration == $value ? 'selected' : '' }}>
                                {{$duration}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label for="duration_pp" class="form-label">Čas přímé péče</label>
                    <select name="duration_pp" id="duration_pp" class="form-select">
                        @foreach($groupDurations as $value => $duration)
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
        <div class="col-sm-8">
            <label for="text">Text intervence</label>
            <textarea name="text" id="text" class="ckeditor">{{ isset($record) ? $record->text : '' }}</textarea>
        </div>
        <div class="col-sm-4">

        </div>
    </div>
    <input type="hidden" name="kind_id" value="2">
    <input type="hidden" name="intervention" value="1">

    <button type="submit" class="btn btn-primary mt-3">{{isset($record) ? 'Upravit skupinovou intervenci' : 'Přidat skupinovou intervenci' }}</button>

    <div class="modal fade" id="clientsModal" tabindex="-1" aria-labelledby="clientsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="clientsModalLabel">Klienti</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="max-height: 60vh; overflow-y: auto;">
                    @foreach($clients as $client)
                        <input name="clients[]" type="checkbox" class="client-modal-checkbox" value="{{ $client->id }}" id="client-{{ $client->id }}"
                            {{ isset($record) && $record->hasClientId($client->id) ? 'checked' : '' }}>
                        <label for="client-{{ $client->id }}">{{ $client->clientCode }}</label><br>

                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" id="applyClientsSelection" class="btn btn-primary">Uložit výběr</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>

    document.addEventListener('DOMContentLoaded', function () {
        const clientsSelect = document.getElementById('clients');
        const clientsModal = document.getElementById('clientsModal');
        const applyClientsSelectionButton = document.getElementById('applyClientsSelection');

        if (!clientsSelect || !clientsModal || !applyClientsSelectionButton) {
            return;
        }

        clientsModal.addEventListener('show.bs.modal', function () {
            const selectedValues = new Set(
                Array.from(clientsSelect.selectedOptions).map(option => option.value)
            );

            clientsModal.querySelectorAll('.client-modal-checkbox').forEach(checkbox => {
                checkbox.checked = selectedValues.has(checkbox.value);
            });
        });

        applyClientsSelectionButton.addEventListener('click', function () {
            const checkedValues = new Set(
                Array.from(clientsModal.querySelectorAll('.client-modal-checkbox:checked'))
                    .map(checkbox => checkbox.value)
            );

            Array.from(clientsSelect.options).forEach(option => {
                option.selected = checkedValues.has(option.value);
            });

            clientsSelect.dispatchEvent(new Event('change', { bubbles: true }));

            const modalInstance = bootstrap.Modal.getInstance(clientsModal);
            if (modalInstance) {
                modalInstance.hide();
            }
        });
    });
</script>
