<div class="card my-2">
    <div class="card-header">
        <span class="badge text-bg-light">{{$record->id}}</span>

        <span class="mx-4">{{$record->place->name ?? ''}} - {{ Carbon\Carbon::parse($record->date)->format('j. n. Y')}}</span>
        <span class="mx-4">{{ $record->duration }}</span>
        <a class="btn btn-outline-primary btn-sm float-end" href="{{route('records.edit', ['record' => $record->id])}}" title="upravit"><i class="bi bi-pencil"></i> upravit záznam</a>
    </div>
    <div class="card-body row">
        <div class="col-sm-2 border-end">
            <p>
                Pracovník:
                @foreach($record->users as $user)
                {{$user->login}}
                @endforeach
            </p>
            <p>
                Klient:
                @if($record->clients->count() > 1)
                <button class="btn btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#group-{{$record->id}}" aria-expanded="false" aria-controls="group-{{$record->id}}">
                    <i class="bi bi-people"></i> Skupinová intervence
                  </button>
                </p>
                <div class="collapse" id="group-{{$record->id}}">
                  <div class="card card-body">
                    @foreach($record->clients as $client)
                    {{$client->clientCode}}<br>
                    @endforeach
                  </div>
                </div>

                @else
                {{$record->clients->first()->clientCode}}
                @endif
            </p>
            <p>
                {!!isset($record->form->name) ? $record->form->name.'<br>' : ''!!}
                {!!isset($record->kind->name) ? $record->kind->name.'<br>' : ''!!}
                {{$record->type->name ?? ''}}
            </p>

        </div>
        <div class="col-sm-10">
            <p class="card-text">{!! $record->text !!}</p>
        </div>

    </div>
</div>
